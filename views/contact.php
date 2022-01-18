<?php  $this->title = 'Contact' ; ?>


    <div class="container">
        <h1>Contact</h1>
        <?php $form = \app\core\form\Form::begin('', 'post'); ?>
        <?php echo $form->field($model, 'email'); ?>
        <?php echo $form->field($model, 'subject'); ?>
        <?php echo new \app\core\form\TextAreaField($model, 'body') ?>
        <button type="submit" class="btn btn-primary">Submit</button>
        <?php echo \app\core\form\Form::end(); ?>
    </div>