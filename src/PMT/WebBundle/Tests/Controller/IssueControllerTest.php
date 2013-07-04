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
        $issue = $this->getMock('\PMT\CoreBundle\Entity\Issue\Issue');



        $issueRepo = $this->getMockBuilder('\PMT\CoreBundle\Entity\Issue\IssueRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $issueRepo->expects($this->once())
            ->method('find')
            ->will($this->returnValue($issue));

        $client = $this->getLoggedInClient();
        $client->getContainer()->set('doctrine.orm.default_entity_manager', $issueRepo);

        $crawler = $client->request('GET', '/code/id');


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
