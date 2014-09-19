<?php
namespace arcane\log
{
    
    interface Log
    {
        
        const DINAME = __CLASS__;
        
        public function log($mixed);
        public function dbg($mixed);
        public function error($mixed);
        
    }
}
