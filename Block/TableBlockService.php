<?php

namespace Sizannia\DataAnalyticsBundle\Block;

use Sizannia\DataAnalyticsBundle\Loader\InterfaceLoader;
use Sizannia\DataAnalyticsBundle\Reader\InterfaceReader;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\BlockBundle\Block\BaseBlockService;
use Sonata\BlockBundle\Block\BlockContextInterface;
use Sonata\AdminBundle\Validator\ErrorElement;
use Symfony\Component\HttpFoundation\Response;
use Sonata\BlockBundle\Model\BlockInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class TableBlockService extends BaseBlockService {

    /**
     * @var InterfaceLoader
     */
    private $loader;

    /**
     * @var InterfaceReader
     */
    private $reader;

    /**
     * @param string $name
     * @param EngineInterface $templating
     * @param InterfaceLoader $loader
     * @param InterfaceReader $reader
     */
    public function __construct($name, EngineInterface $templating, InterfaceLoader $loader, InterfaceReader $reader) {
        parent::__construct($name, $templating);
        $this->loader = $loader;
        $this->reader = $reader;
    }



    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();
        $this->loader->setDimensions($settings['dimensions']);
        $this->loader->setMetrics($settings['metrics']);
        $this->loader->setDateBegin($settings['dateBegin']);
        $this->loader->setDateEnd($settings['dateEnd']);
        $parametersAnalatics = $this->loader->execute();
        $this->reader->parse($parametersAnalatics);
        $parameters = array(
            'settings'   => $blockContext->getSettings(),
            'block'      => $blockContext->getBlock(),
            'dateBegin'  => $settings['dateBegin'],
            'dateEnd'  => $settings['dateEnd'],
            'columnHeaders' => $this->reader->getHeader(),
            'totalResults' => $this->reader->getTotalResults(),
            'rows' => $this->reader->getRows()
        );
        if ($blockContext->getSetting('mode') === 'admin') {
            return $this->renderPrivateResponse($blockContext->getTemplate(), $parameters, $response);
        }
        return $this->renderResponse($blockContext->getTemplate(), $parameters, $response);
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block)
    {
        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('title', 'text', array('required' => false)),
                array('metrics', 'array', array('required' => true)),
                array('interval', 'integer', array('required' => true)),
                array('dimensions', 'array', array('required' => false)),
                array('dateBegin', 'datetime', array('required' => false)),
                array('dateEnd', 'datetime', array('required' => false)),
                array('mode', 'choice', array(
                    'choices' => array(
                        'public' => 'public',
                        'admin'  => 'admin'
                    )
                ))
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return '';
    }
    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver)
    {
        $dateTime = new \DateTime();
        $resolver->setDefaults(array(
            'title'     => 'Recent Contact',
            'metrics'   => array(),
            'interval'  => 30,
            'dimensions' => array(),
            'dateBegin' => new \DateTime('-1 month'),
            'dateEnd'   => new \DateTime(),
            'mode'       => 'public',
            'template'   => 'SizanniaDataAnalyticsBundle:Block:table.html.twig'
        ));
    }
} 