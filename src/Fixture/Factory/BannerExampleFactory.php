<?php

declare(strict_types=1);

namespace Odiseo\SyliusBannerPlugin\Fixture\Factory;

use Faker\Factory;
use Faker\Generator as FakerGenerator;
use Generator;
use Odiseo\SyliusBannerPlugin\Entity\BannerInterface;
use Sylius\Bundle\CoreBundle\Fixture\Factory\AbstractExampleFactory;
use Sylius\Bundle\CoreBundle\Fixture\OptionsResolver\LazyOption;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Locale\Model\LocaleInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\Component\Taxonomy\Repository\TaxonRepositoryInterface;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class BannerExampleFactory extends AbstractExampleFactory
{
    private FactoryInterface $bannerFactory;
    private ChannelRepositoryInterface $channelRepository;
    private TaxonRepositoryInterface $taxonRepository;
    private RepositoryInterface $localeRepository;
    private FakerGenerator $faker;
    private ?FileLocatorInterface $fileLocator;
    private OptionsResolver $optionsResolver;

    public function __construct(
        FactoryInterface $bannerFactory,
        ChannelRepositoryInterface $channelRepository,
        TaxonRepositoryInterface $taxonRepository,
        RepositoryInterface $localeRepository,
        ?FileLocatorInterface $fileLocator = null
    ) {
        $this->bannerFactory = $bannerFactory;
        $this->channelRepository = $channelRepository;
        $this->taxonRepository = $taxonRepository;
        $this->localeRepository = $localeRepository;
        $this->fileLocator = $fileLocator;

        $this->faker = Factory::create();
        $this->optionsResolver = new OptionsResolver();

        $this->configureOptions($this->optionsResolver);
    }

    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefault('channels', LazyOption::randomOnes($this->channelRepository, 3))
            ->setAllowedTypes('channels', 'array')
            ->setNormalizer('channels', LazyOption::findBy($this->channelRepository, 'code'))

            ->setDefault('taxons', [])
            ->setAllowedTypes('taxons', 'array')
            ->setNormalizer('taxons', LazyOption::findBy($this->taxonRepository, 'code'))

            ->setDefault('image', function (Options $_options): string {
                return __DIR__ . '/../../Resources/fixtures/banner/images/0' . rand(1, 4) . '.png';
            })
            ->setAllowedTypes('image', ['string'])

            ->setDefault('mobile_image', function (Options $_options): string {
                return __DIR__ . '/../../Resources/fixtures/banner/mobile-images/0' . rand(1, 4) . '.png';
            })
            ->setAllowedTypes('mobile_image', ['string'])
        ;
    }

    public function create(array $options = []): BannerInterface
    {
        $options = $this->optionsResolver->resolve($options);

        /** @var BannerInterface $banner */
        $banner = $this->bannerFactory->createNew();
        $banner->setCode($this->faker->slug());

        foreach ($options['channels'] as $channel) {
            $banner->addChannel($channel);
        }

        foreach ($options['taxons'] as $taxon) {
            $banner->addTaxon($taxon);
        }

        /** @var string $localeCode */
        foreach ($this->getLocales() as $localeCode) {
            $banner->setCurrentLocale($localeCode);
            $banner->setFallbackLocale($localeCode);

            $banner->setUrl($this->faker->url());
            $banner->setMainText($this->faker->sentence(4));
            $banner->setSecondaryText($this->faker->sentence(9));

            $banner->setImageFile($this->createImage($options['image']));
            $banner->setMobileImageFile($this->createImage($options['mobile_image']));
        }

        return $banner;
    }

    private function createImage(string $imagePath): UploadedFile
    {
        /** @var string $imagePath */
        $imagePath = null === $this->fileLocator ? $imagePath : $this->fileLocator->locate($imagePath);

        return new UploadedFile($imagePath, basename($imagePath));
    }

    private function getLocales(): Generator
    {
        /** @var LocaleInterface[] $locales */
        $locales = $this->localeRepository->findAll();
        foreach ($locales as $locale) {
            yield $locale->getCode();
        }
    }
}
