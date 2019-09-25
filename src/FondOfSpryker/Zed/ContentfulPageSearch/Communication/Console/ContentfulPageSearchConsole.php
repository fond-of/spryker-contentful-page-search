<?php
namespace FondOfSpryker\Zed\ContentfulPageSearch\Communication\Console;

use Spryker\Zed\Kernel\Communication\Console\Console;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Business\ContentfulPageSearchFacadeInterface getFacade()
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Communication\ContentfulPageSearchCommunicationFactory getFactory()
 * @method \FondOfSpryker\Zed\ContentfulPageSearch\Persistence\ContentfulPageSearchToContentfulEntryQueryContainerInterface getQueryContainer()
 */
class ContentfulPageSearchConsole extends Console
{
    public const COMMAND_NAME = 'contentful:restore:page-search';
    public const DESCRIPTION = 'command for restoring fos_contentful_page_search table';
    public const IDS_OPTION = 'ids';
    public const IDS_OPTION_SHORTCUT = 'i';

    /**
     * @var int
     */
    public $limit = 200;

    /**
     * @return void
     */
    protected function configure()
    {
        $this->addOption(
            static::IDS_OPTION,
            static::IDS_OPTION_SHORTCUT,
            InputArgument::OPTIONAL,
            'define the ids which should be fixed'
        );

        $this->setName(static::COMMAND_NAME)
            ->setDescription(static::DESCRIPTION)
            ->addUsage(sprintf('--%s 1,5', static::IDS_OPTION_SHORTCUT));
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $messenger = $this->getMessenger();

        $ids = [];
        if ($input->getOption(static::IDS_OPTION)) {
            $idsString = $input->getOption(static::IDS_OPTION);
            $ids = explode(',', $idsString);
            $this->getFacade()->publish($ids);
        } else {
            $count = $this->getFactory()->getContentfulFacade()->getContentfulEntryCount();
            $offset = 0;
            while ($count > $offset) {
                $ids = $this->getFactory()->getContentfulFacade()->getContentfulEntryIds($this->limit, $offset);
                $this->getFacade()->publish($ids);
                $offset += $this->limit;
            }
        }

        $messenger->info(sprintf(
            'You just executed %s!',
            static::COMMAND_NAME
        ));

        return static::CODE_SUCCESS;
    }
}
