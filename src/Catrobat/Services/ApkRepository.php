<?php

namespace App\Catrobat\Services;

use App\Utils\Utils;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\File;

class ApkRepository
{
  private ?string $dir;

  public function __construct(ParameterBagInterface $parameter_bag)
  {
    $apk_dir = (string) $parameter_bag->get('catrobat.apk.dir');
    Utils::verifyDirectoryExists($apk_dir);
    $this->dir = $apk_dir;
  }

  public function save(File $file, string $id): void
  {
    $file->move($this->dir, $this->generateFileNameFromId($id));
  }

  public function remove(string $id): void
  {
    $path = $this->dir.$this->generateFileNameFromId($id);
    if (is_file($path)) {
      unlink($path);
    }
  }

  public function getProgramFile(string $id): File
  {
    return new File($this->dir.$this->generateFileNameFromId($id));
  }

  private function generateFileNameFromId(string $id): string
  {
    return $id.'.apk';
  }
}
