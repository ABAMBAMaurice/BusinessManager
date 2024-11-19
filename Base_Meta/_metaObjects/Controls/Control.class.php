<?php

    class Control{

        public $_name;
        public $_icon;
        public $_caption;
        private $_designHTML = '';
        public $_onAction;

        private $_style = 'inverse-dark';


        public function __construct($name, $icon = null, $caption=null, $onAction=null, $html='', $style='inverse-dark')
        {
            $this->_name = $name;
            if($icon != null)
                $this->_icon = $icon;
            else
                $this->_icon = '';

            if($caption != null)
                $this->_caption = $caption;
            else
                $this->_caption = $name;

            if($onAction != null)
                $this->_onAction = $onAction;

            $this->_designHTML = $html;
            $this->_style = $style;
        }

        public function HTML(){
            return $this->_designHTML;
        }

        public function onAction(){
            if($this->_onAction != null) {
                if (is_callable($this->_onAction)) {
                    ($this->_onAction)();
                }
            }
        }

        public function __get($name){
            switch($name){
                case "name":
                    return $this->_name;
                    break;
                    case "icon":
                        return $this->_icon;
                        break;
                        case "caption":
                            return $this->_caption;
                            break;
                            case "style":
                                return $this->_style;
                                break;
            }
        }

        public function __set($name, $value){
            switch($name){
                case "html":
                    $this->_designHTML = $value;
                    break;
                    case "style":
                        $this->_style = $value;
                        break;
            }
        }
        public function __toString(){
            return $this->HTML();
        }
    }

?>
