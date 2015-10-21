<?php
class MessageBag {
    public function add($type, $body) {
        $types = ['s', 'a', 'i'];
        if ( in_array($type, $types) )
        {
            $_SESSION['msg'][] = [
                'type' => $type,
                'body' => $body
            ];
        }
        else
        {
            return false;
        }
        return true;
    }
    private function remove() {
        $_SESSION['msg'] = [];
    }
    public function show() {
        $output = [];
        foreach($_SESSION['msg'] as $msg)
        {
            switch($msg['type'])
            {
                case 's':
                    $class = "success";
                    break;
                case 'a';
                    $class = "warning";
                    break;
                case 'i':
                    $class = "info";
                    break;
                default:
                    $class = '';
            }
            $output[] = "<li class='list-group-item list-group-item-{$class}'> {$msg['body']} </li>";
        }
        $this->remove();
        return implode("\n" , $output);
    }
    public function hasErrors() {
    }
    public function hasMsg() {
        if ( empty($_SESSION['msg']) ) {
            return false;
        }
        return true;
    }
}