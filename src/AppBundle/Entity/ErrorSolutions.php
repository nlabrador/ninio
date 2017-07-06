<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ErrorSolutions
 *
 * @ORM\Table(name="error_solutions", indexes={@ORM\Index(name="IDX_2FCD60F6836088D7", columns={"error_id"})})
 * @ORM\Entity
 */
class ErrorSolutions
{
    /**
     * @var string
     *
     * @ORM\Column(name="solution", type="text", nullable=false)
     */
    private $solution;

    /**
     * @var integer
     *
     * @ORM\Column(name="error_solution_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="error_solutions_error_solution_id_seq", allocationSize=1, initialValue=1)
     */
    private $errorSolutionId;

    /**
     * @var \AppBundle\Entity\ApplicationErrors
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ApplicationErrors")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="error_id", referencedColumnName="error_id")
     * })
     */
    private $error;



    /**
     * Set solution
     *
     * @param string $solution
     *
     * @return ErrorSolutions
     */
    public function setSolution($solution)
    {
        $this->solution = $solution;

        return $this;
    }

    /**
     * Get solution
     *
     * @return string
     */
    public function getSolution()
    {
        return $this->solution;
    }

    /**
     * Get errorSolutionId
     *
     * @return integer
     */
    public function getErrorSolutionId()
    {
        return $this->errorSolutionId;
    }

    /**
     * Set error
     *
     * @param \AppBundle\Entity\ApplicationErrors $error
     *
     * @return ErrorSolutions
     */
    public function setError(\AppBundle\Entity\ApplicationErrors $error = null)
    {
        $this->error = $error;

        return $this;
    }

    /**
     * Get error
     *
     * @return \AppBundle\Entity\ApplicationErrors
     */
    public function getError()
    {
        return $this->error;
    }
}
