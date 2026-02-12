<?php
/**
 * Mock CmsApp for testing
 */

if (!class_exists('CmsApp')) {
    class CmsApp
    {
        private static ?CmsApp $instance = null;
        private ?object $db = null;
        
        public static function get_instance(): CmsApp
        {
            if (self::$instance === null) {
                self::$instance = new self();
            }
            return self::$instance;
        }
        
        public function GetDb(): object
        {
            if ($this->db === null) {
                $this->db = new MockDatabase();
            }
            return $this->db;
        }
        
        public function setDb(object $db): void
        {
            $this->db = $db;
        }
        
        public static function reset(): void
        {
            self::$instance = null;
        }
    }
}

// Global function that CMSMS modules use
if (!function_exists('cmsms')) {
    function cmsms(): CmsApp
    {
        return CmsApp::get_instance();
    }
}

// cms_db_prefix function
if (!function_exists('cms_db_prefix')) {
    function cms_db_prefix(): string
    {
        return 'cms_';
    }
}
