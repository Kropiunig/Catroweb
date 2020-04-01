<?php

namespace App\Catrobat\Services\CatrobatCodeParser\Bricks;

use App\Catrobat\Services\CatrobatCodeParser\Constants;

class LegoEV3MotorMoveBrick extends Brick
{
  protected function create(): void
  {
    $this->type = Constants::LEGO_EV3_MOTOR_MOVE_BRICK;
    $this->caption = 'Set EV3 motor _ to _ % Power for _ seconds';
    $this->setImgFile(Constants::LEGO_EV3_BRICK_IMG);
  }
}
