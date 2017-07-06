<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ApplicationErrors
 *
 * @ORM\Table(name="application_errors", indexes={@ORM\Index(name="IDX_8C625FD83E030ACD", columns={"application_id"})})
 * @ORM\Entity
 */
class ApplicationErrors
{
    /**
     * @var string
     *
     * @ORM\Column(name="error", type="string", length=255, nullable=false)
     */
    private $error;

    /**
     * @var string
     *
     * @ORM\Column(name="notify", type="text", nullable=true)
     */
    private $notify;

    /**
     * @var integer
     *
     * @ORM\Column(name="error_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="application_errors_error_id_seq", allocationSize=1, initialValue=1)
     */
    private $errorId;

    /**
     * @var \AppBundle\Entity\Applications
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Applications")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="application_id", referencedColumnName="application_id")
     * })
     */
    private $application;



    /**
     * Set error
     *
     * @param string $error
     *
     * @return ApplicationErrors
     */
    public function setError($error)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get error
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Set notify
     *
     * @param string $notify
     *
     * @return ApplicationErrors
     */
    public function setNotify($notify)
    {
        $this->notify = $notify;

        return $this;
    }

    /**
     * Get notify
     *
     * @return string
     */
    public function getNotify()
    {
        return $this->notify;
    }

    /**
     * Get errorId
     *
     * @return integer
     */
    public function getErrorId()
    {
        return $this->errorId;
    }

    /**
     * Set application
     *
     * @param \AppBundle\Entity\Applications $application
     *
     * @return ApplicationErrors
     */
    public function setApplication(\AppBundle\Entity\Applications $application = null)
    {
        $this->application = $application;

        return $this;
    }

    /**
     * Get application
     *
     * @return \AppBundle\Entity\Applications
     */
    public function getApplication()
    {
        return $this->application;
    }
}
