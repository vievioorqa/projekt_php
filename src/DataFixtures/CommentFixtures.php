<?php
/**
 * Comment fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class CommentFixtures.
 */
class CommentFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     */
    public function loadData(): void
    {
        for ($i = 0; $i < 10; ++$i) {
            $comment = new Comment();
            $comment->setText($this->faker->sentence);
            $comment->setNick($this->faker->word);
            $comment->setEmail(sprintf('user%d@example.com', $i));

            /** @var Masterpiece $masterpiece */
            $masterpiece = $this->getRandomReference('masterpieces');
            $comment->setMasterpiece($masterpiece);

            $this->manager->persist($comment);
        }

        $this->manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return string[] of dependencies
     *
     * @psalm-return array{0: MasterpieceFixtures::class}
     */
    public function getDependencies(): array
    {
        return [MasterpieceFixtures::class];
    }
}
