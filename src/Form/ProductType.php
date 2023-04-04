<?php
namespace App\Form;

use App\Entity\Product;
use App\Service\ProductService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    /**
     * @var ProductService $productService
     */
    private $productService;

    /**
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $productChoices = $this->productService->getAllProducts();

        $builder
            ->add('product', ChoiceType::class, [
                'label' => 'Выберите продукт',
                'choices' => $productChoices,
                'multiple' =>false,
                'choice_label' => function (Product $product = null) {
                    return $product ? $product->getName() . ' (' . $product->getPrice() . ' евро)' : '';
                },
                'choice_value' => function (Product $product = null) {
                    return $product?->getId();
                },
            ])
            ->add('taxNumber', TextType::class, [
                'label' => 'Введите tax номер',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Рассчитать цену',
                'attr' => ['class' => 'btn btn-primary'],
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => null,
        ]);
    }
}