<?= "<?" ?>

<?= $table->getNamespace($ns) ?>

trait <?= $prefix . $table->getName(true) ?>
{
  use TEntity;
  use \arcane\db\DI;

<? foreach ($table->columns as $column): ?>
        // <?= $column ?>;
        private $<?= $column->getName() ?>;
<? endforeach; ?>

        private function __init() {
<? foreach ($table->columns as $column): ?>

           $a = $this->__attribute(new Attribute('<?=$column->getName()?>', '<?=$column->getType()?>'));
           $a->null = '<?=$column->Null?>';
           $a->key = '<?=$column->Key?>';

<? if ($column->getTypePrecision()): ?>
           $a->precision = <?=$column->getTypePrecision()?>;
<? endif;?>


<? endforeach; ?>
        }

<? foreach ($table->columns as $column): ?>
        public function get<?= $column->getName(true) ?>() {
               return $this->__attribute('<?= $column->getName()?>')->get();
        }
        public function set<?= $column->getName(true) ?>($value) {
               $this->__attribute('<?= $column->getName() ?>')->set($value);
        }
<? endforeach; ?>

   public function load()
   {
        $sql = $this->__sql_load();
        $result = $this->db()->fetch($sql, $this);
        $this->feed(array_shift($result));
        return $this;
   }
   public function __sql_load()
   {
        return "<?= $table->sqlLoad() ?>";
   }

   public function save()
   {
        $sql = $this->__sql_save();
        $this->db()->execute($sql, $this);
        return $this;
   }
   public function __sql_save()
   {
        return "<?= $table->sqlSave() ?>";
   }

   public function update()
   {
        $sql = $this->__sql_update();
        $this->db()->execute($sql, $this);
        return $this;
   }
   public function __sql_update()
   {
        return "<?= $table->sqlUpdate() ?>";
   }

   public function insert()
   {
        $sql = $this->__sql_insert();
        $this->db()->execute($sql, $this);
        return $this;
   }
   public function __sql_insert()
   {
        return "<?= $table->sqlInsert() ?>";
   }

   public function delete()
   {
        $sql = $this->__sql_delete();
        $this->db()->execute($sql, $this);
        return $this;
   }
   public function __sql_delete()
   {
        return "<?= $table->sqlDelete() ?>";
   }
}
