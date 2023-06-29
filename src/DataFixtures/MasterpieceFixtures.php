<?php
/**
 * Masterpiece fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Category;
// use App\Entity\Tag;
use App\Entity\Masterpiece;
// use App\Entity\User;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

/**
 * Class MasterpieceFixtures.
 */
class MasterpieceFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Load data.
     *
     * @psalm-suppress PossiblyNullPropertyFetch
     * @psalm-suppress PossiblyNullReference
     * @psalm-suppress UnusedClosureParam
     */
    public function loadData(): void
    {
        if (null === $this->manager || null === $this->faker) {
            return;
        }

        $this->createMany(30, 'masterpieces', function (int $i) {
            $masterpiece = new Masterpiece();
            $masterpiece->setTitle($this->faker->unique()->word);
            $masterpiece->setCreatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );
            $masterpiece->setUpdatedAt(
                \DateTimeImmutable::createFromMutable(
                    $this->faker->dateTimeBetween('-100 days', '-1 days')
                )
            );
            $masterpiece->setAuthor($this->faker->word);
            $masterpiece->setDescription($this->faker->sentence);

            /** @var Category $category */
            $category = $this->getRandomReference('categories');
            $masterpiece->setCategory($category);

            return $masterpiece;
        });

        $this->manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on.
     *
     * @return string[] of dependencies
     *
     * @psalm-return array{0: CategoryFixtures::class}
     */
    public function getDependencies(): array
    {
        return [CategoryFixtures::class];
    }
}
