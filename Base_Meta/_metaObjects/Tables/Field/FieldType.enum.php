<?php
    enum FieldType: string{
        case text = 'VARCHAR';
        case integer = 'INT';
        case date = 'DATE';
        case time = 'TIME';
        case datetime = 'DATETIME';
        case decimal = 'DECIMAL';
        case boolean = 'BOOLEAN';

        // Static methods to define each case with a message format
        public static function text($length):string
        {
            return 'VARCHAR('.$length.')';
        }

        public static function integer():string{
            return 'INT';
        }
        public static function date():string{
            return 'DATE';
        }
        public static function time():string{
            return 'TIME';
        }
        public static function datetime():string{
            return 'DATETIME';
        }
        public static function decimal():string{
            return 'DECIMAL';
        }
        public static function boolean():string{
            return 'BOOLEAN';
        }

    }

?>
