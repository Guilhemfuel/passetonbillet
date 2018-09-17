<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RobotController extends Controller
{
    /**
     *  Controller to generate dynamic robots.txt file (based on env.)
     */


    public function index() {

        if (\App::environment() == 'production') {
            return \Response::make($this->productionRobot(), 200, array('content-type' => 'text/plain'));

        } else {
            return \Response::make($this->devRobot(), 200, array('content-type' => 'text/plain'));
        }
    }

    /**
     * Default 'Disallow /' for every robot
     * @return string user agent and disallow string
     */
    protected function productionRobot() {
        return 'User-agent: *' . PHP_EOL . 'Disallow: ';
    }

    /**
     * Default 'Disallow /' for every robot
     * @return string user agent and disallow string
     */
    protected function devRobot() {
        return 'User-agent: *' . PHP_EOL . 'Disallow: /';
    }

}



