<?php
$entity = $vars['entity'];
?>

<div class="rhs-row">
    <div class="rhs-col-md-offset-2 rhs-col-md-8">
        <?php echo elgg_view_entity($entity, array(
            'full_view' => true
        )); ?>

        <?php if (elgg_is_logged_in()): ?>
            <div data-forum-answer-block="" class="rhs-edit-block__wrapper" style="">
                <?php echo elgg_view_form("pinboard/comment", array(
                    'name' => 'pinboard_comment',
                    'class' => 'rhs-edit-block',
                    'action' => 'action/comment/save'
                ), array(
                    'entity' => $entity
                )); ?>
            </div>
        <?php endif; ?>

        <div class="rhs-card-user-content__amount">
            <span><?php echo $entity->countComments(); ?></span> <?php echo ($count==1) ? elgg_echo("rijkshuisstijl:count:answer") : elgg_echo("rijkshuisstijl:count:answers"); ?>
        </div>
        <?php echo elgg_list_entities(array(
            'type' => 'object',
            'subtype' => 'comment',
            'container_guid' => $entity->guid,
            'order_by' => 'time_created DESC',
            'limit' => false,
            'pagination' => false
        )); ?>
    </div>
</div>