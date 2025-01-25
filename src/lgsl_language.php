<?php
    namespace tltneon\LGSL;
    class Lang {
        const AR = "arabic";
        const BG = "bulgarian";
        const CN = "chinese_simplified";
        const CZ = "czech";
        const EN = "english";
        const FR = "french";
        const GE = "german";
        const HB = "hebrew";
        const KO = "korean";
        const RO = "romanian";
        const RU = "russian";
        const SL = "slovak";
        const SP = "spanish";
        const TR = "turkish";
        private string $lang;
        private array $strings;
        function __construct(?string $lang = null) {
            global $lgsl_config;
            if (!$lang) {
                if (isset($lgsl_config['language'])) {
                    $lang = $lgsl_config['language'];
                } else {
                    $lang = self::EN;
                }
            }
            $this->lang = $lang;
            include_once("languages/$lang.php");
            $this->strings = $lgsl_config['text'];
        }
        public function get(string $code): string {
            if (empty($this->strings[$code])) return "#LGSL_NO_STRING# {$code} for {$this->lang}";
            return $this->strings[$code];
        }
        public function isRtl() {
            return in_array($this->lang, [self::HB]);
        }
        static function list() {
            return [self::AR, self::BG, self::CN, self::CZ, self::EN, self::FR, self::GE, self::HB, self::KO, self::RO, self::RU, self::SL, self::SP, self::TR];
        }
    }