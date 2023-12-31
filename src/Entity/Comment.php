<?php
/**
 * Comment entity.
 */

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;
use PharIo\Manifest\Email;

/**
 * Class Comment.
 *
 * @psalm-suppress MissingConstructor
 */
#[ORM\Entity(repositoryClass: CommentRepository::class)]
#[ORM\Table(name: 'comments')]
class Comment
{

    /**
     * Id
     *
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;


    /**
     * Text
     *
     * @var string|null
     */
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $text = null;


    /**
     * Email
     *
     * @var string|null
     */
    #[ORM\Column(length: 191)]
    private ?string $email = null;


    /**
     * @var string|null
     */
    #[ORM\Column(length: 45)]
    private ?string $nick = null;


    /**
     * Masterpiece
     *
     * @var Masterpiece|null
     */
    #[ORM\ManyToOne(targetEntity: Masterpiece::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Masterpiece $masterpiece = null;

    /**
     * Getter for Id.
     *
     * @return int|null Id
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Getter for text.
     *
     * @return string|null Text
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * Setter for text.
     *
     * @param string|null $text Text
     */
    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    /**
     * Getter for Masterpiece
     *
     * @return Masterpiece|null
     */
    public function getMasterpiece(): ?Masterpiece
    {
        return $this->masterpiece;
    }

    /**
     * Setter form Masterpiece
     *
     * @param Masterpiece|null $masterpiece
     * @return $this
     */
    public function setMasterpiece(?Masterpiece $masterpiece): static
    {
        $this->masterpiece = $masterpiece;

        return $this;
    }

    /**
     * Getter for Email
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Setter for Masterpiece
     *
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Getter for Nick
     *
     * @return string|null
     */
    public function getNick(): ?string
    {
        return $this->nick;
    }

    /**
     *
     * Setter for Nick
     *
     * @param string $nick
     * @return $this
     */
    public function setNick(string $nick): static
    {
        $this->nick = $nick;

        return $this;
    }
}
