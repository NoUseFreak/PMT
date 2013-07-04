<?php

namespace PMT\WebBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IssueControllerTest extends WebTestCase
{
    protected $client;

    private $issue;

    public function testForm()
    {
        $client = $this->getLoggedInClient();
        $crawler = $client->request('GET', '/add');

        $this->assertGreaterThan(0, $crawler->filter('html h1:contains("issue.form.newissue")')->count());

    }

    /**
     * @depends testForm
     */
    public function testDetail()
    {
        $client = $this->getLoggedInClient();
        $crawler = $client->request('GET', '/code/1');

        $this->assertGreaterThan(0, $crawler->filter('h1:contains("issue")')->count());
    }

    protected function getLoggedInClient($client = null)
    {
        if (is_null($client)) {
            $client = static::createClient();
        }

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
