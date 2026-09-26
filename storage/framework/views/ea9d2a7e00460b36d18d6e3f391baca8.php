<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($subject); ?></title>
    <style>
        .main-container {
            width: 70%; 
            margin-left: auto;
            margin-right: auto;
            border: 1px solid #F9BD24;
            padding: 10px;
            border-radius: 10px;
        }

        .logo-div {
            text-align: center;
        }

        .logo-img{
            max-width: 100px;
            height: auto;
        }
        .link{
            background:black;
            padding:0.3em;
            border-radius:5px;
        }
        .link > a{
            font-size: 16px;
            font-weight: 700;
            text-decoration: none;
            color: #F9BD24;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="logo-div">
            <a href="<?php echo e(route('home')); ?>">
            <img class="logo-img" src="<?php echo e(asset('images/logo.png')); ?>">
            </a>
        </div>
        
        <div class="header">
            <h1>
                <?php echo e($subject); ?>

            </h1>
        </div>

        <div class="message">
            <p>
                <?php echo e($mailMessage); ?>

            </p>

            <?php if($emailLink != null): ?>
            <span class="link">
                <a href="<?php echo e($emailLink); ?>" >Download</a>
            </span>
            <?php endif; ?>
        </div>
    </div>

</body>
</html><?php /**PATH C:\Users\Hammad-Khan\OneDrive\Documents\School Management Software\resources\views\emails\basic.blade.php ENDPATH**/ ?>