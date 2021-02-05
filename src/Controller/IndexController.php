<?php


namespace App\Controller;


use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class IndexController extends AbstractController
{

    /**
     * @Route("/", name="app_home")
     * @param CarRepository $carRepository
     * @return Response
     */
    public function index(CarRepository $carRepository): Response
    {
        $cars =$carRepository->findAll();
        return $this->render('page/index.html.twig',['cars'=>$cars]);
    }

    /**
     * @Route("/show/{id}", name="app_show")
     * @param Car $car
     * @return Response
     */
    public function show(Car $car): Response
    {
        return $this->render('page/show.html.twig',[
            'car' => $car
        ]);
    }

    /**
     * @Route("/add", name="app_add")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    public function add(EntityManagerInterface $manager,Request $request): Response
    {
//        Ajout de mots clés pour une voiture
//        $car = new Car();
//        $car->setModel("Laguna 3");
//        $car->setPrice("2500");
//
//        $keywordSpacieuse = new Keyword();
//        $keywordSpacieuse->setName('spacieuse');
//
//        $keywordNonFumeur = new Keyword();
//        $keywordNonFumeur->setName('Non fumeur');
//
//        $car->addKeywords($keywordNonFumeur);
//        $car->addKeywords($keywordSpacieuse);
//
//        $manager->persist($car);
//        $manager->flush();
//        $this->addFlash(
//            'notice',
//            'Voiture ajouter ! '
//        );
//        return $this->redirectToRoute('app_home');

        $form = $this->createForm(CarType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $path = $this->getParameter('kernel.project_dir').'/public/img';
            //Récupère les données sous form d'objet car
            $car = $form->getData();
            //Récupère l'image
            /**@var Image $image */
            $image  = $car->getImage();
            //Récupère le file soumis
            /**@var UploadedFile $file */
            $file = $image->getFile();
            //Créer un nom unique
            $name = md5(uniqid()).'.'.$file->guessExtension();
            //Déplace le fichier
            $file->move($path,$name);
            //Donne le nom à l'image
            $image->setName($name);

            $manager->persist($car);
            $manager->flush();
            $this->addFlash(
                'notice',
                'Voiture ajouter ! '
            );
            return $this->redirectToRoute('app_home');
        }
        return $this->render('page/add.html.twig',['form'=>$form->createView()]);
    }

    /**
     * @Route("/edit/{id}", name="app_edit")
     * @param Car $car
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    public function edit(Car $car, EntityManagerInterface $manager,Request $request): Response
    {
        $form = $this->createForm(CarType::class, $car);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
                $manager->flush();
                $this->addFlash('notice', 'La voiture à bien été éditer !');
                return $this->redirectToRoute('app_home');
        }
        return $this->render('page/edit.html.twig',[
            'car'=>$car,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="app_delete")
     * @param Car $car
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function delete(Car $car, EntityManagerInterface $manager): Response
    {
        $manager->remove($car);
        $manager->flush();
        return $this->redirectToRoute('app_home');
    }

    /**
     * @Route("/contact", name="app_contact")
     * @return Response
     */
    public function contact(): Response
    {
        return $this->render('page/contact.html.twig');
    }

}