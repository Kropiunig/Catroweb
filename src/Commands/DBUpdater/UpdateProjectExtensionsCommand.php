<?php

namespace App\Commands\DBUpdater;

use App\Entity\Extension;
use App\Repository\ExtensionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateProjectExtensionsCommand extends Command
{
  protected static $defaultName = 'catrobat:update:extensions';

  private EntityManagerInterface $entity_manager;
  private ExtensionRepository $extension_repository;

  public const EXTENSION_LTM_PREFIX = 'extension.extension.';

  public function __construct(EntityManagerInterface $entity_manager, ExtensionRepository $extension_repository)
  {
    parent::__construct();
    $this->entity_manager = $entity_manager;
    $this->extension_repository = $extension_repository;
  }

  protected function configure(): void
  {
    $this->setName('catrobat:create:extensions')
      ->setDescription('Inserting our static project extension into the Database')
    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $count = 0;

    $extension = $this->getOrCreateExtension(Extension::ARDUINO, 1)
      ->setTitleLtmCode(self::EXTENSION_LTM_PREFIX.'arduino.title')
      ->setEnabled(true)
        ;
    ++$count;
    $this->entity_manager->persist($extension);

    $extension = $this->getOrCreateExtension(Extension::DRONE, 2)
      ->setTitleLtmCode(self::EXTENSION_LTM_PREFIX.'drone.title')
      ->setEnabled(true)
      ;
    ++$count;
    $this->entity_manager->persist($extension);

    $extension = $this->getOrCreateExtension(Extension::PHIRO, 4)
      ->setTitleLtmCode(self::EXTENSION_LTM_PREFIX.'phiro.title')
      ->setEnabled(true)
      ;
    ++$count;
    $this->entity_manager->persist($extension);

    $extension = $this->getOrCreateExtension(Extension::RASPBERRY_PI, 5)
      ->setTitleLtmCode(self::EXTENSION_LTM_PREFIX.'raspberry_pi.title')
      ->setEnabled(true)
      ;
    ++$count;
    $this->entity_manager->persist($extension);

    $extension = $this->getOrCreateExtension(Extension::EMBROIDERY, 6)
      ->setTitleLtmCode(self::EXTENSION_LTM_PREFIX.'embroidery.title')
      ->setEnabled(true)
      ;
    ++$count;
    $this->entity_manager->persist($extension);

    $extension = $this->getOrCreateExtension(Extension::MINDSTORMS, 7)
      ->setTitleLtmCode(self::EXTENSION_LTM_PREFIX.'mindstorms.title')
      ->setEnabled(true)
      ;
    ++$count;
    $this->entity_manager->persist($extension);

    $this->entity_manager->flush();
    $output->writeln("{$count} Tags in the Database have been inserted/updated");

    return 0;
  }

  /**
   * ToDo: id is deprecated -- remove once transition was made.
   */
  protected function getOrCreateExtension(string $internal_title, int $id = 0): Extension
  {
    $tag = $this->extension_repository->findOneBy(['internal_title' => $internal_title]);
    if (is_null($tag)) {
      $tag = $this->extension_repository->findOneBy(['id' => $id]) ?? new Extension();
    }

    return $tag->setInternalTitle($internal_title);
  }
}
