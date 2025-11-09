<?php

    namespace App\Entity;

    use Doctrine\ORM\Mapping as ORM;
    use Symfony\Component\Validator\Constraints as Assert;
    use App\Repository\UserRepository;

    #[ORM\Entity(repositoryClass: \App\Repository\UserRepository::class)]
    #[ORM\Table(name: 'users')]
    #[ORM\HasLifecycleCallbacks]
    class User {

        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(type: 'integer')]
        private ?int $id = null;

        #[ORM\Column(type: 'string', length: 100)]
        private ?string $name = null;

        #[ORM\Column(type: 'string', length: 100, unique: true)]
        private ?string $email = null;

        #[ORM\Column(type: 'string', length: 20, unique: true)]
        private ?string $phone = null;

        #[ORM\Column(type: 'string', length: 100)]
        private ?string $type = null;

        #[ORM\Column(type: 'boolean')]
        private ?bool $isActive = null;

        #[ORM\Column(type: 'datetime')]
        private ?\DateTimeInterface $createdAt = null;

        #[ORM\Column(type: 'datetime', nullable: true)]
        private ?\DateTimeInterface $modifiedAt = null;

        public function getId(): ?int {

            return $this->id;

        }

        public function getName(): ?string {

            return $this->name;

        }

        public function setName(string $name): self {

            $this->name = $name;
            return $this;

        }

        public function getEmail(): ?string {

            return $this->email;

        }

        public function setEmail(string $email): self {

            $this->email = $email;
            return $this;

        }

        public function getPhone(): ?string {

            return $this->phone;

        }

        public function setPhone(string $phone): self {

            $this->phone = $phone;
            return $this;

        }

        public function getType(): ?string {

            return $this->type;

        }

        public function setType(string $type): self {

            $this->type = $type;
            return $this;

        }

        public function isActive(): ?bool {

            return $this->isActive;

        }

        public function setIsActive(bool $isActive): self {

            $this->isActive = $isActive;
            return $this;

        }

        public function getCreatedAt(): ?\DateTimeInterface {

            return $this->createdAt;

        }

        public function setCreatedAt(\DateTimeInterface $createdAt): self {

            $this->createdAt = $createdAt;
            return $this;

        }

        public function getModifiedAt(): ?\DateTimeInterface {

            return $this->modifiedAt;

        }

        public function setModifiedAt(?\DateTimeInterface $modifiedAt): self {

            $this->modifiedAt = $modifiedAt;
            return $this;

        }

        #[ORM\PrePersist]
        public function setCreatedAtValue(): void
        {
            $this->createdAt = new \DateTimeImmutable();
            $this->modifiedAt = new \DateTimeImmutable();
        }

        #[ORM\PreUpdate]
        public function setModifiedAtValue(): void
        {
            $this->modifiedAt = new \DateTimeImmutable();
        }

    }