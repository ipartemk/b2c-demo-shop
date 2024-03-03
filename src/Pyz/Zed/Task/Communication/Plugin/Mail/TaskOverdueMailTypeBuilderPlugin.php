<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Task\Communication\Plugin\Mail;

use Generated\Shared\Transfer\MailTemplateTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\MailExtension\Dependency\Plugin\MailTypeBuilderPluginInterface;

/**
 * @method \Pyz\Zed\Task\Business\TaskFacadeInterface getFacade()
 * @method \Pyz\Zed\Task\TaskConfig getConfig()
 */
class TaskOverdueMailTypeBuilderPlugin extends AbstractPlugin implements MailTypeBuilderPluginInterface
{
    /**
     * @var string
     */
    public const MAIL_TYPE = 'TASK_OVERDUE_NOTIFICATION_MAIL';

    /**
     * @var string
     */
    private const MAIL_TEMPLATE_HTML = 'Task/mail/overdue-notification.html.twig';

    /**
     * @var string
     */
    private const MAIL_TEMPLATE_TEXT = 'Task/mail/overdue-notification.text.twig';

    /**
     * @var string
     */
    private const MAIL_SUBJECT = 'Task overdue notification.';

    /**
     * @return string
     */
    public function getName(): string
    {
        return self::MAIL_TYPE;
    }

    /**
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return \Generated\Shared\Transfer\MailTransfer
     */
    public function build(MailTransfer $mailTransfer): MailTransfer
    {
        return $mailTransfer
            ->setSubject(self::MAIL_SUBJECT)
            ->addTemplate(
                (new MailTemplateTransfer())
                    ->setName(self::MAIL_TEMPLATE_HTML)
                    ->setIsHtml(true),
            )
            ->addTemplate(
                (new MailTemplateTransfer())
                    ->setName(self::MAIL_TEMPLATE_TEXT)
                    ->setIsHtml(false),
            );
    }
}
