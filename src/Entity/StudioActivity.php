<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use InvalidArgumentException;

/**
 * Class Studio_user.
 *
 * @ORM\Entity(repositoryClass="App\Repository\Studios\StudioActivityRepository")
 * @ORM\Table(name="studio_activity")
 */
class StudioActivity
{
  /**
   * adding new constant requires adding it to the enum in the annotation of the column.
   */
  public const TYPE_COMMENT = 'comment';
  public const TYPE_PROJECT = 'project';
  public const TYPE_USER = 'user';

  private array $activity_types = [self::TYPE_COMMENT, self::TYPE_PROJECT, self::TYPE_USER];

  /**
   * @ORM\Id
   * @ORM\Column(name="id", type="integer")
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected ?int $id;

  /**
   * @ORM\ManyToOne(targetEntity="Studio", cascade={"persist"})
   * @ORM\JoinColumn(name="studio", referencedColumnName="id", nullable=false, onDelete="CASCADE")
   */
  protected Studio $studio;

  /**
   * @ORM\Column(name="type", type="string", columnDefinition="ENUM('comment', 'project', 'user')", nullable=false)
   */
  protected string $type;

  /**
   * @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
   * @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=false, onDelete="CASCADE")
   */
  protected User $user;

  /**
   * @ORM\Column(name="created_on", type="datetime", nullable=false)
   */
  protected DateTime $created_on;

  public function getId(): ?int
  {
    return $this->id;
  }

  public function setId(?int $id): StudioActivity
  {
    $this->id = $id;

    return $this;
  }

  public function getStudio(): Studio
  {
    return $this->studio;
  }

  public function setStudio(Studio $studio): StudioActivity
  {
    $this->studio = $studio;

    return $this;
  }

  public function getType(): string
  {
    return $this->type;
  }

  public function setType(string $type): StudioActivity
  {
    if (!in_array($type, $this->activity_types, true)) {
      throw new InvalidArgumentException('invalid activity type given');
    }
    $this->type = $type;

    return $this;
  }

  public function getUser(): User
  {
    return $this->user;
  }

  public function setUser(User $user): StudioActivity
  {
    $this->user = $user;

    return $this;
  }

  public function getCreatedOn(): DateTime
  {
    return $this->created_on;
  }

  public function setCreatedOn(DateTime $created_on): StudioActivity
  {
    $this->created_on = $created_on;

    return $this;
  }
}
