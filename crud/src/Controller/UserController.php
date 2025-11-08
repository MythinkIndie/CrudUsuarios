<?php
    namespace App\Controller;

    use App\Entity\User;
    use App\Form\UserType;
    use App\Repository\UserRepository;
    use Doctrine\ORM\EntityManagerInterface;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;

    #[Route("/usuarios")]
    class UserController extends AbstractController {

        #[Route("", name: "user_index", methods: ["GET"])]
        public function index(UserRepository $repo, Request $request): Response {

            $term = $request->query->get("q", "");
            $users = $term ? $repo->searchUsers($term) : $repo->findBy([], ["name" => "ASC"]);

            return $this->render("user/index.html.twig", compact("users", "term"));

        }

        #[Route("/new", name: "user_new", methods: ["GET", "POST"])]
        public function new(Request $request, EntityManagerInterface $em): Response {

            $user = new User();
            $form = $this->createForm(UserType::class, $user);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $em->persist($user);
                $em->flush();

                $this->addFlash("success", "Usuario Creado");
                return $this->redirectToRoute("user_index");

            }

            return $this->render("user/new.html.twig", ["form" => $form->createView()]);

        }

        #[Route("/{id}", name: "user_show", requirements: ["id" => "\\d+"], methods: ["GET"])]
        public function show(User $user): Response {

            return $this->render("user/show.html.twig", compact("user"));

        }

        #[Route("/{id}/editar", name: "user_edit", methods: ["GET", "POST"])]
        public function edit(Request $request, User $user, EntityManagerInterface $em): Response {

            $form = $this->createForm(UserType::class, $user);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $em->flush();

                $this->addFlash("success", "Usuario Actualizado");
                return $this->redirectToRoute("user_index");

            }

            return $this->render("user/edit.html.twig", ["form" => $form->createView(), "user" => $user]);

        }

        #[Route("/{id}", name: "user_delete", methods: ["POST"])]
        public function delete(Request $request, User $user, EntityManagerInterface $em): Response {

            if ($this->isCsrfTokenValid("delete".$user->getId(), $request->request->get("_token"))) {

                $em->remove($user);
                $em->flush();

                $this->addFlash("success", "Usuario Eliminado");

            }

            return $this->redirectToRoute("user_index");

        }

    }