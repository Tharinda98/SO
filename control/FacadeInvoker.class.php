<?php
class FacadeInvoker{
    public function getSO(){
        $factory = new ControllerFactory();
        $ctrl=$factory->getController("SO");
        return $ctrl->givetoadmin();
    }
}
?>
