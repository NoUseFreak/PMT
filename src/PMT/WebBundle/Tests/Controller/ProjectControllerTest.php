<?php

namespace PMT\WebBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProjectControllerTest extends WebTestCase
{
    protected $client;

    public function testForm()
    {
        $client = $this->getLoggedInClient();
        $crawler = $client->request('GET', '/project/create');

        $this->assertGreaterThan(0, $crawler->filter('html h1:contains("project.form.new")')->count());

        $form = $crawler->selectButton('_submit')->form(
            array(
                'project[name]' => 'name',
                'project[name]' => 'code',
            )
        );

        $client->submit($form);
    }

    /**
     * @depends testForm
     */
    public function testDetail()
    {
        $client = $this->getLoggedInClient();
        $crawler = $client->request('GET', '/project/summary');

        $this->assertGreaterThan(0, $crawler->filter('.row-fluid h1')->count());
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
