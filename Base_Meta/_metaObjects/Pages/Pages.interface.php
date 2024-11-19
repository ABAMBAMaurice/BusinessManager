<?php
    interface Pages
    {

        public function OnOpenPage();

        public function OnClosePage();

        public function HTML();

        function layout();
        function setActions();

        public function Validate($field, $value);

    }

?>