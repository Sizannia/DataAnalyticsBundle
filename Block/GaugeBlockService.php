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

class GaugeBlockService extends BaseBlockService {

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        $settings = $blockContext->getSettings();
        $parameters = array(
            'settings'   => $blockContext->getSettings(),
            'block'      => $blockContext->getBlock(),
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
                array('interval', 'integer', array('required' => true)),
                array('mode', 'choice', array(
                    'choices' => array(
                        'public' => 'public',
                        'admin'  => 'admin'
                    )
                )),
                array('url', 'text', array('required' => true))
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
            'interval'  => 30,
            'mode'       => 'public',
            'url' => '',
            'template'   => 'SizanniaDataAnalyticsBundle:Block:gauge.html.twig'
        ));
    }
} 