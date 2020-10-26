<?php

/**
 *
 */
class ControllerFactory
{

  public function getController($controllerType)
  {
    $controller = NULL;
        switch ($controllerType) {
            case "CASHIER":
                $controller = new CashierControl();
                break;
            case "ADMIN":
                $controller = new AdminControl();
                break;
            case "ENGINEER":
                $controller = new EngineerControl();
                break;
            case "SO":
                $controller = new SoControl();
                break;
            case "User":
                $controller = new UserControl();
                break;
            case "Profile":
                $controller = new ProfileControl();
                break;
            default:
                $controller = NULL;
            break;
        }
    return $controller;
  }
}

?>
