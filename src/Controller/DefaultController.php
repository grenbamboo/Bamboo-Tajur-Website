<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\DBAL\Driver\Connection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function index()
    {
        return $this->render('homepage.html.twig');
    }

    public function sendInquiry(Connection $conn, Request $request, \Swift_Mailer $mailer){
        date_default_timezone_set('Asia/Jakarta');
    	$name 			= trim($request->request->get('nama'));
    	$no				= trim($request->request->get('phone'));
    	$email 			= trim($request->request->get('email'));
    	$created_date	= date("Y-m-d H:i:s");

    	//$conn->insert('inquiry_nw_grandbali', array('nama' => $name, 'hp' => $no, 'email' => $email, 'payment' => $payment, 'created_date' => $created_date));

    	//if ($conn->lastInsertId() != ''){
    		$response = new Response(json_encode(array('status' => 'success', 'message' => 'Email sudah terkirim')));

            $message = (new \Swift_Message('Inquiry from web'))
            ->setFrom(array('inquiry@bambootajur.com' => 'Inqury Web'))
            ->setTo('bambootajur@gmail.com')
            ->setBody(
                $this->renderView(
                    'email/inquiry.html.twig',
                    array('name' => $name, 'email' => $email, 'phone' => $no)
                ),
                'text/html'
            );

        $mailer->send($message);

    	//} else {
    	//	$response = new Response(json_encode(array('status' => 'failed', 'message' => 'Gagal kirim email')));
    	//}

    	$response->headers->set('Content-Type', 'application/json');

		return $response;

    }

    public function sendEmail(Request $request, \Swift_Mailer $mailer){
        $name           = trim($request->request->get('nama'));
        $no             = $request->request->get('phone');
        $email          = $request->request->get('email');
        $payment        = $request->request->get('payment');
        $created_date   = date("Y-m-d H:i:s");

        $message = (new \Swift_Message('Inquiry from web'))
            ->setFrom('contact@shinmichi.co.id')
            ->setTo('prasetyama@gmail.com')
            ->setBody(
                $this->renderView(
                    'email/inquiry.html.twig',
                    array('name' => $name, 'email' => $email, 'phone' => $no, 'payment' => $payment)
                ),
                'text/html'
            )
        ;

        $mailer->send($message);

        $response = new Response(json_encode(array('status' => 'success', 'message' => 'Email sudah terkirim')));

        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    public function about(){
        return $this->render('about.html.twig');
    }

    public function project(Request $request){
        return $this->render('project.html.twig');
    }
	
	public function contact(){
        return $this->render('contact.html.twig');
    }
	
	public function news(){
        return $this->render('news.html.twig');
    }
}