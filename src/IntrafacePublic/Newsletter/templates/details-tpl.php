<h1><?php e(__('Newsletter'))?></h1>
            
<form action="<?php e(url('.')); ?>" method="post">

<?php if(isset($message)): ?>
    <p class="alert"><?php e(__($message)); ?></p>
<?php endif; ?>

<fieldset class="details-customer clearfix">
    <legend><?php e(__('Please fill in your informations below')); ?></legend>

    <div class="row">
        <label for="name"><?php e(__('Name')); ?></label>
        <input type=text name="name" value="<?php if(!empty($name)) e($name); ?>" />
    </div>
    
    <div class="row">
        <label for="email"><?php e(__('E-mail')); ?></label>
        <input type="text" name="email" value="<?php if(!empty($email)) e($email); ?>" />
    </div>
    
    <div class="row">
        <label for="subscribe"><?php e(__('Subscribe')); ?></label>
        <input value="1" id="subscribe" type="radio" name="mode" checked="checked" />
    </div>
    
    <div class="row">
        <label for="unsubscribe"><?php e(__('Unsubscribe')); ?></label>
        <input value="2" id="unsubscribe" type="radio" name="mode" />
    </div>
    
</fieldset>
<div>
    <input value="Save" type="submit" />
</div>
</form>