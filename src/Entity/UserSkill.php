<?php

namespace App\Entity;

use App\Repository\UserSkillRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserSkillRepository::class)
 */
class UserSkill
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="binary")
     */
    private $liked;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="userSkills")
     */
    private $user_id;

    /**
     * @ORM\ManyToOne(targetEntity=Skill::class, inversedBy="userSkills")
     * @ORM\JoinColumn(nullable=false)
     */
    private $skill_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLiked()
    {
        return $this->liked;
    }

    public function setLiked($liked): self
    {
        $this->liked = $liked;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getSkillId(): ?Skill
    {
        return $this->skill_id;
    }

    public function setSkillId(?Skill $skill_id): self
    {
        $this->skill_id = $skill_id;

        return $this;
    }
}
