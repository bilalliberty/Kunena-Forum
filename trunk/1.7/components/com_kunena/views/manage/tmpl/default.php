<?php
/**
 * @version		$Id$
 * Kunena Component
 * @package Kunena
 *
 * @Copyright (C) 2008 - 2010 Kunena Team All rights reserved
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 * @link http://www.kunena.com
 */
defined('_JEXEC') or die;

JHTML::_ ( 'behavior.mootools' );
$document = JFactory::getDocument();
$document->addStyleSheet ( JURI::base().'components/com_kunena/media/css/admin.css' );
$document->addScript ( JURI::base().'/includes/js/joomla.javascript.js' );
?>
<div id="Kunena">
	<div class="kadmin-functitle icon-adminforum"><?php echo JText::_('COM_KUNENA_ADMIN'); ?></div>
		<form action="index.php" method="post" name="adminForm">
			<table class="kadmin-sort">
				<tr>
					<td class="left" width="90%">
						<?php echo JText::_( 'Filter' ); ?>:
						<input type="text" name="search" id="search" value="<?php echo $this->escape ( $this->state->{'list.search'} );?>" class="text_area" onchange="document.adminForm.submit();" />
						<button onclick="this.form.submit();"><?php echo JText::_( 'Go' ); ?></button>
						<button onclick="document.getElementById('search').value='';this.form.submit();"><?php echo JText::_( 'Reset' ); ?></button>
					</td>
				</tr>
			</table>
			<table class="adminlist">
				<thead>
					<tr>
						<th align="center" width="5">#</th>
						<th width="5"><input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count ( $this->categories ); ?>);" /></th>
						<th class="title"><?php echo JHTML::_('grid.sort', JText::_('COM_KUNENA_CATEGORY'), 'name', $this->state->{'list.direction'}, $this->state->{'list.ordering'} ); ?></th>
						<th><small><?php echo JHTML::_('grid.sort', JText::_('COM_KUNENA_CATID'), 'id', $this->state->{'list.direction'}, $this->state->{'list.ordering'} ); ?></small></th>
						<th width="100" class="center nowrap"><small>
							<?php echo JHTML::_('grid.sort', JText::_('COM_KUNENA_REORDER'), 'ordering', $this->state->{'list.direction'}, $this->state->{'list.ordering'} ); ?>
							<?php echo JHTML::_('grid.order',  $this->categories ); ?></small>
						</th>
						<th class="center"><small><?php echo JText::_('COM_KUNENA_LOCKED'); ?></small></th>
						<th class="center"><small><?php echo JText::_('COM_KUNENA_MODERATED'); ?></small></th>
						<th class="center"><small><?php echo JText::_('COM_KUNENA_REVIEW'); ?></small></th>
						<th class="center"><small><?php echo JText::_('COM_KUNENA_CATEGORY_ANONYMOUS'); ?></small></th>
						<th class="center"><small><?php echo JText::_('COM_KUNENA_ADMIN_POLLS'); ?></small></th>
						<th class="center"><small><?php echo JText::_('COM_KUNENA_PUBLISHED'); ?></small></th>
						<th class="center"><small><?php echo JText::_('COM_KUNENA_PUBLICACCESS'); ?></small></th>
						<th class="center"><small><?php echo JText::_('COM_KUNENA_ADMINACCESS'); ?></small></th>
						<th class="center"><small><?php echo JText::_('COM_KUNENA_CHECKEDOUT'); ?></small></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="14">
							<div class="pagination">
								<div class="limit"><?php echo JText::_('COM_KUNENA_A_DISPLAY'); ?> <?php echo $this->navigation->getLimitBox (); ?></div>
								<?php echo $this->navigation->getPagesLinks (); ?>
								<div class="limit"><?php echo $this->navigation->getResultsCounter (); ?></div>
							</div>
						</td>
					</tr>
				</tfoot>
		<?php
			$k = 0;
			$i = 0;
			$n = count($this->categories);
			$img_yes = '<img src="images/tick.png" alt="'.JText::_('COM_KUNENA_A_YES').'" />';
			$img_no = '<img src="images/publish_x.png" alt="'.JText::_('COM_KUNENA_A_NO').'" />';
			foreach($this->categories as $category) {
		?>
			<tr <?php echo 'class = "row' . $k . '"';?>>
				<td class="right"><?php echo $i + $this->navigation->limitstart + 1; ?></td>
				<td><?php echo JHTML::_('grid.id', $i, intval($category->id)) ?></td>
				<td class="left" width="70%"><a href="#edit" onclick="return listItemTask('cb<?php echo $i ?>','edit')"><?php echo $category->treename; ?></a></td>
				<td class="center"><?php echo intval($category->id); ?></td>

				<?php if (! $category->category): ?>

				<td class="right nowrap">
					<span><?php echo $this->navigation->orderUpIcon ( $i, $category->up, 'orderup', 'Move Up', 1 ); ?></span>
					<span><?php echo $this->navigation->orderDownIcon ( $i, $n, $category->down, 'orderdown', 'Move Down', 1 ); ?></span>
					<input type="text" name="order[<?php echo intval($category->id) ?>]" size="5" value="<?php echo intval($category->ordering); ?>" class="text_area center" />
				</td>
				<td colspan="5" class="center"><?php echo JText::_('COM_KUNENA_SECTION') ?></td>

				<?php else: ?>

				<td class="right nowrap">
					<span><?php echo $this->navigation->orderUpIcon ( $i, $category->up, 'orderup', 'Move Up', 1 ); ?></span>
					<span><?php echo $this->navigation->orderDownIcon ( $i, $n, $category->down, 'orderdown', 'Move Down', 1 ); ?></span>
					<input type="text" name="order[<?php echo intval($category->id) ?>]" size="5" value="<?php echo $this->escape ( $category->ordering ); ?>" class="text_area" style="text-align: center" />
				</td>
				<td class="center">
					<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i; ?>','<?php echo ($category->locked ? 'un':'').'lock'; ?>')">
						<?php echo ($category->locked == 1 ? $img_yes : $img_no); ?>
					</a>
				</td>
				<td class="center">
					<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i; ?>','<?php echo  ($category->moderated ? 'un':'').'moderate'; ?>')">
						<?php echo ($category->moderated == 1 ? $img_yes : $img_no); ?>
					</a>
				</td>
				<td class="center">
					<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i; ?>','<?php echo ($category->review ? 'un':'').'review'; ?>')">
						<?php echo ($category->review == 1 ? $img_yes : $img_no); ?>
					</a>
				</td>
				<td class="center">
					<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i; ?>','<?php echo ($category->allow_anonymous ? 'deny':'allow').'_anonymous'; ?>')">
						<?php echo ($category->allow_anonymous == 1 ? $img_yes : $img_no); ?>
					</a>
				</td>
				<td class="center">
					<a href="javascript: void(0);" onclick="return listItemTask('cb<?php echo $i; ?>','<?php echo ($category->allow_polls ? 'deny':'allow').'_polls'; ?>')">
						<?php echo ($category->allow_polls == 1 ? $img_yes : $img_no); ?>
					</a>
				</td>

				<?php endif; ?>

				<td class="center"><?php echo JHTML::_('grid.published', $category, $i) ?></td>
				<td width="" align="center"><?php echo $this->escape ( $category->groupname ); ?></td>
				<td width="" align="center"><?php echo $this->escape ( $category->admingroup ); ?></td>
				<td width="15%" align="center"><?php echo $this->escape ( $category->editor ); ?></td>
			</tr>
				<?php
				$i++;
				$k = 1 - $k;
				}
				?>
		</table>

		<input type="hidden" name="option" value="com_kunena" />
		<input type="hidden" name="view" value="manage" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="filter_order" value="<?php echo intval ( $this->state->{'list.ordering'} ) ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo intval ( $this->state->{'list.direction'} ) ?>" />
		<input type="hidden" name="limitstart" value="<?php echo intval ( $this->navigation->limitstart ) ?>" />
		<input type="hidden" name="boxchecked" value="0" />
		<?php echo JHTML::_( 'form.token' ); ?>
		</form>
</div>