<?php
/**
 * Mock CMSModule for testing CMSMS modules outside the CMS environment
 */

if (!class_exists('CMSModule')) {
    abstract class CMSModule
    {
        protected array $params = [];
        protected array $parameterTypes = [];
        protected array $langStrings = [];
        protected ?object $smarty = null;
        
        public function __construct()
        {
            $this->loadLangStrings();
        }
        
        protected function loadLangStrings(): void
        {
            $langFile = dirname((new ReflectionClass($this))->getFileName()) . '/lang/en_US.php';
            if (file_exists($langFile)) {
                $lang = [];
                include $langFile;
                $this->langStrings = $lang;
            }
        }
        
        public function Lang(string $key, ...$args): string
        {
            $str = $this->langStrings[$key] ?? $key;
            if (!empty($args)) {
                $str = vsprintf($str, $args);
            }
            return $str;
        }
        
        public function SetParameterType(string $name, int $type): void
        {
            $this->parameterTypes[$name] = $type;
        }
        
        public function RestrictUnknownParams(): void
        {
            // Mock implementation
        }
        
        public function RegisterModuleRoute(string $route): void
        {
            // Mock implementation
        }
        
        public function GetModulePath(): string
        {
            return dirname((new ReflectionClass($this))->getFileName());
        }
        
        public function GetModuleURLPath(): string
        {
            return '/modules/' . $this->GetName();
        }
        
        public function GetPreference(string $key, $default = '')
        {
            return $default;
        }
        
        public function SetPreference(string $key, $value): void
        {
            // Mock implementation
        }
        
        public function CreateFormStart(string $id, string $action = '', string $returnid = '', array $params = []): string
        {
            return '<form method="post" action="' . htmlspecialchars($action) . '">';
        }
        
        public function CreateFormEnd(): string
        {
            return '</form>';
        }
        
        public function CreateInputSubmit(string $id, string $name, string $value = '', string $addtext = ''): string
        {
            return '<input type="submit" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '" ' . $addtext . '/>';
        }
        
        public function CreateInputText(string $id, string $name, string $value = '', int $size = 10, int $max = 255): string
        {
            return '<input type="text" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '" size="' . $size . '" maxlength="' . $max . '"/>';
        }
        
        public function CreateInputHidden(string $id, string $name, string $value = ''): string
        {
            return '<input type="hidden" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '"/>';
        }
        
        public function CreateLink(string $id, string $action, string $returnid = '', string $contents = '', array $params = []): string
        {
            return '<a href="#">' . htmlspecialchars($contents) . '</a>';
        }
        
        public function Redirect(string $id, string $action, string $returnid = '', array $params = []): void
        {
            throw new \RuntimeException("Redirect to: $action");
        }
        
        // Abstract methods modules must implement (no return types for CMSMS compatibility)
        abstract public function GetName();
        abstract public function GetFriendlyName();
        abstract public function GetVersion();
    }
}
