
<?php if(!empty(\Auth::user()->avatar)): ?>
    <div class="avatar av-l" style="background-image: url('<?php echo e(asset('/storage/'.config('chatify.user_avatar.folder').\Auth::user()->avatar)); ?>');">
    </div>
<?php else: ?>
    <div class="avatar av-l"
         style="background-image: url('<?php echo e(asset('/storage/'.config('chatify.user_avatar.folder').'/avatar.png')); ?>');">
    </div>
<?php endif; ?>

<p class="info-name"><?php echo e(config('chatify.name')); ?></p>
<div class="messenger-infoView-btns">
    
    <a href="#" class="danger delete-conversation"><i class="fas fa-trash-alt"></i> <?php echo e(__('Delete Conversation')); ?></a>
</div>

<div class="messenger-infoView-shared">
    <p class="messenger-title"><?php echo e(__('shared photos')); ?></p>
    <div class="shared-photos-list"></div>
</div>
<?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/messenger/layouts/info.blade.php ENDPATH**/ ?>