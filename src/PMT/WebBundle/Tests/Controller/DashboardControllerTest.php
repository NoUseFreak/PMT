<?php

namespace PMT\WebBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DashboardControllerTest extends WebTestCase
{
    protected $client;

    public function testDashboardFirewall()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertContains('/login', $client->getResponse()->headers->get('location'));
    }

    public function testDashboard()
    {
        $client = $this->getLoggedInClient();
        $crawler = $client->request('GET', '/');

        $this->assertGreaterThan(0, $crawler->filter('html h1:contains("dashboard.dashboard")')->count());
    }

    protected function getLoggedInClient()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');
        $form = $crawler->selectButton('_submit')->form(
            array(
                '_username' => getenv('PMTWEB_AUTH_USER'),
                '_password' => getenv('PMTWEB_AUTH_PASSWORD'),
            )
        );
        $client->submit($form);
        $client->followRedirect();

        return $client;
    }
}
