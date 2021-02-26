<?php $__env->startPush('css-page'); ?>
<meta name="route" content="<?php echo e($route); ?>">
<meta name="url" content="<?php echo e(url('').'/'.config('chatify.path')); ?>" data-user="<?php echo e(Auth::user()->id); ?>">


<script src="<?php echo e(asset('js/chatify/font.awesome.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/chatify/autosize.js')); ?>"></script>

<script src='https://unpkg.com/nprogress@0.2.0/nprogress.js'></script>


<link rel='stylesheet' href='https://unpkg.com/nprogress@0.2.0/nprogress.css' />
<link href="<?php echo e(asset('css/chatify/style.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('css/chatify/'.$dark_mode.'.mode.css')); ?>" rel="stylesheet" />


<?php echo $__env->make('messenger.layouts.messengerColor', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('page-title'); ?>
<?php echo e(__('Messenger')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<h6 class="h2 d-inline-block mb-0"><?php echo e(__('Messenger')); ?></h6>
<nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
    <ol class="breadcrumb breadcrumb-links">
        <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
        <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
        <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Messenger')); ?></li>
    </ol>
</nav>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="messenger rounded min-h-750 overflow-hidden mt-4">
                
                <div class="messenger-listView">
                    
                    <div class="m-header">
                        <nav>
                            
                            
                            <nav class="m-header-right">
                                <a href="#" class="listView-x"><i class="fas fa-times"></i></a>
                            </nav>
                        </nav>
                        
                        <input type="text" class="messenger-search" placeholder="<?php echo e(__('Search')); ?>" />
                        
                        <div class="messenger-listView-tabs">
                            <a href="#" <?php if($route=='user' ): ?> class="active-tab" <?php endif; ?> data-view="users">
                                <span class="fas fa-clock" title="<?php echo e(__('Recent')); ?>"></span>
                            </a>
                            <a href="#" <?php if($route=='group' ): ?> class="active-tab" <?php endif; ?> data-view="groups">
                                <span class="fas fa-users" title="<?php echo e(__('Members')); ?>"></span>
                            </a>
                        </div>
                    </div>
                    
                    <div class="m-body">
                        
                        
                        <div class="<?php if($route == 'user'): ?> show <?php endif; ?> messenger-tab app-scroll" data-view="users">

                            
                            <p class="messenger-title"><?php echo e(__('Favorites')); ?></p>
                            <div class="messenger-favorites app-scroll-thin"></div>

                            
                            <?php echo view('messenger.layouts.listItem', ['get' => 'saved','id' => $id])->render(); ?>


                            
                            <div class="listOfContacts" style="width: 100%;height: calc(100% - 200px);"></div>

                        </div>

                        
                        <div class="all_members <?php if($route == 'group'): ?> show <?php endif; ?> messenger-tab app-scroll" data-view="groups">
                            
                            <p style="text-align: center;color:grey;"><?php echo e(__('Soon will be available')); ?></p>
                        </div>

                        
                        <div class="messenger-tab app-scroll" data-view="search">
                            
                            <p class="messenger-title"><?php echo e(__('Search')); ?></p>
                            <div class="search-records">
                                <p class="message-hint"><span><?php echo e(__('Type to search..')); ?></span></p>
                            </div>
                        </div>
                    </div>
                </div>

                
                <div class="messenger-messagingView">
                    
                    <div class="m-header m-header-messaging">
                        <nav>
                            
                            <div style="display: inline-block;">
                                
                                <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i> </a>
                                <?php if(!empty(\Auth::user()->avatar)): ?>
                                <div class="avatar av-s header-avatar" style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px;background-image: url('<?php echo e(asset('/storage/uploads/avatar/'.\Auth::user()->avatar)); ?>');"></div>
                                <?php else: ?>
                                <div class="avatar av-s header-avatar" style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px;background-image: url('<?php echo e(asset('/storage/uploads/avatar/avatar.png')); ?>');"></div>
                                <?php endif; ?>
                                <a href="#" class="user-name"><?php echo e(config('chatify.name')); ?></a>
                            </div>
                            
                            <nav class="m-header-right">
                                <a href="#" class="add-to-favorite"><i class="fas fa-star"></i></a>
                                <a href="#" class="show-infoSide"><i class="fas fa-info-circle"></i></a>
                            </nav>
                        </nav>
                    </div>
                    
                    <div class="internet-connection">
                        <span class="ic-connected"><?php echo e(__('Connected')); ?></span>
                        <span class="ic-connecting"><?php echo e(__('Connecting...')); ?></span>
                        <span class="ic-noInternet"><?php echo e(__('No internet access')); ?></span>
                    </div>
                    
                    <div class="m-body app-scroll">
                        <div class="messages">
                            <p class="message-hint" style="margin-top: calc(30% - 126.2px);"><span><?php echo e(__('Please select a chat to start messaging')); ?></span></p>
                        </div>
                        
                        <div class="typing-indicator">
                            <div class="message-card typing">
                                <p>
                                    <span class="typing-dots">
                                        <span class="dot dot-1"></span>
                                        <span class="dot dot-2"></span>
                                        <span class="dot dot-3"></span>
                                    </span>
                                </p>
                            </div>
                        </div>
                        
                        <?php echo $__env->make('messenger.layouts.sendForm', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
                
                <div class="messenger-infoView app-scroll text-center">
                    
                    <nav class="text-left">
                        <a href="#"><i class="fas fa-times"></i></a>
                    </nav>
                    <?php echo view('messenger.layouts.info')->render(); ?>

                </div>
            </div>
        </div>
    </div>
</div>


<div id="imageModalBox" class="imageModal">
    <span class="imageModal-close">&times;</span>
    <img class="imageModal-content" id="imageModalBoxSrc">
</div>


<div class="app-modal" data-name="delete">
    <div class="app-modal-container">
        <div class="app-modal-card" data-name="delete" data-modal='0'>
            <div class="app-modal-header"><?php echo e(__('Are you sure you want to delete this?')); ?></div>
            <div class="app-modal-body"><?php echo e(__('You can not undo this action')); ?></div>
            <div class="app-modal-footer">
                <a href="javascript:void(0)" class="app-btn cancel"><?php echo e(__('Cancel')); ?></a>
                <a href="javascript:void(0)" class="app-btn a-btn-danger delete"><?php echo e(__('Delete')); ?></a>
            </div>
        </div>
    </div>
</div>

<div class="app-modal" data-name="alert">
    <div class="app-modal-container">
        <div class="app-modal-card" data-name="alert" data-modal='0'>
            <div class="app-modal-header"></div>
            <div class="app-modal-body"></div>
            <div class="app-modal-footer">
                <a href="javascript:void(0)" class="app-btn cancel"><?php echo e(__('Cancel')); ?></a>
            </div>
        </div>
    </div>
</div>

<div class="app-modal" data-name="settings">
    <div class="app-modal-container">
        <div class="app-modal-card" data-name="settings" data-modal='0'>
            <form id="updateAvatar" action="<?php echo e(route('avatar.update')); ?>" enctype="multipart/form-data" method="POST">
                <?php echo csrf_field(); ?>
                <div class="app-modal-header"><?php echo e(__('Update your profile settings')); ?></div>
                <div class="app-modal-body">
                    
                    <?php if(!empty(\Auth::user()->avatar)): ?>
                    <div class="avatar av-l upload-avatar-preview" style="background-image: url('<?php echo e(asset('/storage/'.config('chatify.user_avatar.folder').\Auth::user()->avatar)); ?>');"></div>
                    <?php else: ?>
                    <div class="avatar av-l upload-avatar-preview" style="background-image: url('<?php echo e(asset('/storage/'.config('chatify.user_avatar.folder').'/avatar.png')); ?>');"></div>
                    <?php endif; ?>
                    <p class="upload-avatar-details"></p>
                    <label class="app-btn a-btn-primary update">
                        <?php echo e(__('Upload profile photo')); ?>

                        <input class="upload-avatar" accept="image/*" name="avatar" type="file" style="display: none" />
                    </label>
                    
                    <p class="divider"></p>
                    <p class="app-modal-header"><?php echo e(__('Dark Mode')); ?> <span class="
                        <?php echo e(Auth::user()->dark_mode > 0 ? 'fas' : 'far'); ?> fa-moon dark-mode-switch" data-mode="<?php echo e(Auth::user()->dark_mode > 0 ? 1 : 0); ?>"></span></p>
                    
                    <p class="divider"></p>
                    <p class="app-modal-header"><?php echo e(__('Change')); ?> <?php echo e(config('chatify.name')); ?> <?php echo e(__('Color')); ?></p>
                    <div class="update-messengerColor">
                        <a href="javascript:void(0)" class="messengerColor-1"></a>
                        <a href="javascript:void(0)" class="messengerColor-2"></a>
                        <a href="javascript:void(0)" class="messengerColor-3"></a>
                        <a href="javascript:void(0)" class="messengerColor-4"></a>
                        <a href="javascript:void(0)" class="messengerColor-5"></a>
                        <br />
                        <a href="javascript:void(0)" class="messengerColor-6"></a>
                        <a href="javascript:void(0)" class="messengerColor-7"></a>
                        <a href="javascript:void(0)" class="messengerColor-8"></a>
                        <a href="javascript:void(0)" class="messengerColor-9"></a>
                        <a href="javascript:void(0)" class="messengerColor-10"></a>
                    </div>
                </div>
                <div class="app-modal-footer">
                    <a href="javascript:void(0)" class="app-btn cancel"><?php echo e(__('Cancel')); ?></a>
                    <input type="submit" class="app-btn a-btn-success update" value="Update" />
                </div>
            </form>
        </div>
    </div>
</div>


<?php echo $__env->make('messenger.layouts.modals', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script-page'); ?>
<?php echo $__env->make('messenger.layouts.footerLinks', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<script>
    window.onload = function() {
        if (("Notification" in window)) {
            Notification.requestPermission().then((perm) => {
                if (perm === "granted") {
                    var notif = new Notification("Granted");
                }
            })
        }
    }
</script>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/mitaapps/public_html/dekomdmc/main_file/resources/views/messenger/app.blade.php ENDPATH**/ ?>