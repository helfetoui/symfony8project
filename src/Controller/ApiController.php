<?php

namespace App\Controller;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

use Embed\Embed;

use App\Repository\BookmarkRepository;
use App\Entity\Bookmark;

#[Route('/api/bookmarks', name: 'app_api_',methods:["GET"])]
class ApiController extends AbstractController
{
   
    #[Route('', name: 'books')]

    public function index(BookmarkRepository $bookmarkRepository): JsonResponse
    {
     
        $bookmarks = $bookmarkRepository->findall();

        $encoder = new JsonEncoder();

        $normalizer = new ObjectNormalizer();

        $serializer = new Serializer([$normalizer], [$encoder]);
     
        return JsonResponse::fromJsonString($serializer->serialize($bookmarks, 'json'));
       
    }


    #[Route('/{id}', name: 'book',methods:["GET"])]

    public function view(BookmarkRepository $bookmarkRepository,int $id): JsonResponse
    {
        $bookmark = $bookmarkRepository->find($id);
        
        if($bookmark){
            $data = 
            [
               'id' => $bookmark->getId(),
               'URL' => $bookmark->getURL(),
               'type' => $bookmark->getType(),
               'title' => $bookmark->getTitle(),
               'author' => $bookmark->getAuthor(),
               'provider' => $bookmark->getProvider(),
               'width' => $bookmark->getWidth(),
               'height' => $bookmark->getHeight(),
               'pub_at' => $bookmark->getPubAt()->getTimestamp() ,
               'created_at' => $bookmark->getCreatedAt()->getTimestamp() ,
               'updated_at' => $bookmark->getUpdatedAt()->getTimestamp() ,
            ];
            if($data['type'] == 'video'&& $data['provider']== 'Vimeo'){
                $duration = $bookmark->getDuration();
                $data['duration']=$duration ;

            }

            return $this->json($data);
        }
            
        else 
            return  $this->json(['message' => 'book Not Found'], 404);
    }


    #[Route('', name: 'add_book',methods:["POST"])]

    public function add(Request $request,BookmarkRepository $bookmarkRepository ): JsonResponse
    {

        $url = $request->request->get("url");

        if(empty($url) || !filter_var($url, FILTER_VALIDATE_URL)){
            return  $this->json(['message' => 'url not valide'], 500);
        }

        if( !filter_var($url, FILTER_VALIDATE_URL) || !(str_starts_with($url,'http://') || str_starts_with($url,'https://'))){
            return  $this->json(['message' => 'url not valide'], 500);
        } else{
         
            $embed = new Embed();
            $info = $embed->get($url);
            $oembed = $info->getOEmbed();
            

            

            $data =$oembed->all();
            if(!is_array($data) || !array_key_exists("provider_name",$data)){
                return  $this->json(['message' => 'url not valide'], 500);
            }

            $title = $oembed->str('title');
            $type = $data["type"];
            $pro = $data["provider_name"];
            $author_name = $data["author_name"];
            $width = $data["width"];
            $height = $data["height"];

             $bookmark = new Bookmark();

            $bookmark->setURL($url);
            $bookmark->setType($type);
            $bookmark->setProvider($pro);
            $bookmark->setTitle($title);
            $bookmark->setAuthor($author_name);

            if($type == 'video'&& $pro == 'Vimeo'){
                $duration = $data["duration"];
                $bookmark->setDuration($duration);

            }

            $bookmark->setWidth($width);
            $bookmark->setHeight($height);
            
            $bookmark->setPubAt(new \DateTimeImmutable());

            $bookmarkRepository->add($bookmark,true);
       
            return  $this->json(['message' => 'book added'], 200);
        }
    }




    #[Route('/{id}', name: 'delete_book',methods:["DELETE"])]

    public function delete(BookmarkRepository $bookmarkRepository,int $id): JsonResponse
    {
        $bookmark = $bookmarkRepository->find($id);
        
        if($bookmark){
            $bookmarkRepository->remove($bookmark,true);
            return  $this->json(['message' => 'bookmark is Deleted']);
        }
        else 
            return  $this->json(['message' => 'bookmark Not found'], 404);
    }




}
