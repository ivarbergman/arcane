<?

namespace arcane\config;
{

    interface Config
    {

        const DINAME = __CLASS__;

        public function get($ns, $key = null);
        public function set($value, $ns, $key = null);
        public function load($ns, $path);

    }
}
