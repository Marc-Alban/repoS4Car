<?php


namespace App\Form;


use App\Services\CarProvider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class SearchCarType extends AbstractType
{
    const PRICE = [1000,2000,3000,4000,5000];

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

       $builder
           ->add("color",ChoiceType::class, [
               'choices' => array_combine(CarProvider::COLOR, CarProvider::COLOR )
           ])
           ->add("fuel",ChoiceType::class, [
               'choices' => array_combine(CarProvider::FUEL, CarProvider::FUEL )
           ])
           ->add("minPrice", ChoiceType::class,[
               'label' => 'prix minimum',
               'choices' => array_combine(self::PRICE, self::PRICE)
           ])

           ->add("maxPrice", ChoiceType::class,[
               'label' => 'prix maximum',
               'choices' => array_combine(self::PRICE, self::PRICE)
           ])

           ->add('rechercher', SubmitType::class)
       ;
    }
}