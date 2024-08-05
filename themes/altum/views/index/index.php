<?php defined('ALTUMCODE') || die() ?>

<div class="container mt-5">
    <?= \Altum\Alerts::output_alerts() ?>
        <div class="card index-pattern">
        <div class="card-body py-5" style="background-image: url('https://i.imgur.com/nxm9eOI.jpeg'); background-size: cover; background-position: ">

            <div class="row justify-content-center">
                <div class="col-11 col-md-10 col-lg-8 col-xl-7">
                    <h1 class="index-header text-center mb-2"><?= l('index.header') ?></h1>
                </div>

                <div class="col-10 col-sm-8 col-lg-7 col-xl-6">
                    <p class="index-subheader text-center mb-5"><?= l('index.subheader') ?></p>
                </div>
            </div>

            <?php if(settings()->users->register_is_enabled && !\Altum\Authentication::check()): ?>
                <div class="text-center">
                    <a href="<?= url('register') ?>" class="btn btn-primary index-button mb-2 mb-lg-0 mr-lg-2"><?= l('index.register') ?> <i class="fas fa-fw fa-sm fa-arrow-right"></i></a>
                </div>
            <?php endif ?>

            <?php if(\Altum\Authentication::check()): ?>
                <div class="text-center">
                    <a href="<?= url('document-create') ?>" class="btn btn-primary index-button mb-2 mb-lg-0 mr-lg-2"><?= l('documents.create') ?> <i class="fas fa-fw fa-sm fa-arrow-right"></i></a>
                </div>
            <?php endif ?>

            <div class="d-flex justify-content-center mt-5">
                <ul class="list-style-none d-flex flex-column flex-lg-row">
                    <li class="d-flex align-items-center mb-2 mb-lg-0 mx-lg-3">
                        <i class="fas fa-fw mr-2 fa-check-circle text-success"></i>
                        <div class="text-muted">
                            <?= l('index.feature.one') ?>
                        </div>
                    </li>

                    <li class="d-flex align-items-center mb-2 mb-lg-0 mx-lg-3">
                        <i class="fas fa-fw mr-2 fa-check-circle text-success"></i>
                        <div class="text-muted">
                            <?= l('index.feature.two') ?>
                        </div>
                    </li>

                    <li class="d-flex align-items-center mb-2 mb-lg-0 mx-lg-3">
                        <i class="fas fa-fw mr-2 fa-check-circle text-success"></i>
                        <div class="text-muted">
                            <?= l('index.feature.three') ?>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>

<div class="my-4">&nbsp;</div>

<div class="container">
    <div class="row">
        <div class="col-12 col-lg p-3 position-relative text-truncate" data-aos="fade-up" data-aos-delay="100">
            <div class="card d-flex flex-row h-100 overflow-hidden">
                <div class="px-4 d-flex flex-column justify-content-center">
                    <span class="h1 m-0 text-primary">1</span>
                </div>

                <div class="card-body pl-2 text-wrap">
                    <span class="h6"><?= l('index.widgets.one.header') ?></span>
                    <div class="small text-muted"><?= l('index.widgets.one.subheader') ?></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg p-3 position-relative text-truncate" data-aos="fade-up" data-aos-delay="200">
            <div class="card d-flex flex-row h-100 overflow-hidden">
                <div class="px-4 d-flex flex-column justify-content-center">
                    <span class="h1 m-0 text-primary">2</span>
                </div>

                <div class="card-body pl-2 text-wrap">
                    <span class="h6"><?= l('index.widgets.two.header') ?></span>
                    <div class="small text-muted"><?= l('index.widgets.two.subheader') ?></div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg p-3 position-relative text-truncate" data-aos="fade-up" data-aos-delay="300">
            <div class="card d-flex flex-row h-100 overflow-hidden">
                <div class="px-4 d-flex flex-column justify-content-center">
                    <span class="h1 m-0 text-primary">3</span>
                </div>

                <div class="card-body pl-2 text-wrap">
                    <span class="h6"><?= l('index.widgets.three.header') ?></span>
                    <div class="small text-muted"><?= l('index.widgets.three.subheader') ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="my-5">&nbsp;</div>

<div class="container">
    <div class="row">
        <?php foreach($data->templates as $template_id => $template): ?>
            <div class="col-12 col-lg-4 p-3 icon-zoom-animation">
                <div class="card d-flex flex-column justify-content-between h-100">
                    <div class="card-body">
                        <div class="mb-3 p-3 rounded w-fit-content" style="background: <?= $data->templates_categories[$template->template_category_id]->background ?>">
                            <i class="<?= $template->icon ?> fa-fw fa-lg" style="color: <?= $data->templates_categories[$template->template_category_id]->color ?>"></i>
                        </div>

                        <div class="mb-2">
                            <span class="h5"><?= $template->settings->translations->{\Altum\Language::$name}->name ?></span>
                        </div>
                        <span class="text-muted"><?= $template->settings->translations->{\Altum\Language::$name}->description ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</div>

<?php if(settings()->aix->images_is_enabled && settings()->aix->images_display_latest_on_index): ?>
    <div class="my-5">&nbsp;</div>

    <div class="container">
        <div class="text-center mb-4">
            <h3 class="h3"><?= sprintf(l('index.images'), nr(8, 0, true, true)) ?></h3> <!-- Update the total number of images -->
            <p class="text-muted"><?= l('index.images_subheader') ?></p>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row no-gutters">
                    <?php 
                    $images = [
                        'image1.jpg', 
                        'image2.jpg', 
                        'image3.jpg', 
                        'image4.jpg', 
                        'image5.jpg', 
                        'image6.jpg', 
                        'image7.jpg', 
                        'image8.jpg'
                    ];

                    foreach($images as $image): ?>
                        <div class="col-6 col-lg-3 p-3" data-aos="zoom-in">
                            <div class="img-wrapper">
                                <img src="<?= 'uploads/images/' . $image ?>" class="img-fluid rounded" alt="<?= $image ?>" data-toggle="tooltip" title="<?= $image ?>" loading="lazy" />
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<style>
.img-wrapper {
    width: 100%;
    height: 200px; /* Set a fixed height */
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Ensures images cover the entire container while maintaining aspect ratio */
}
</style>




<?php if(settings()->aix->transcriptions_is_enabled || settings()->aix->syntheses_is_enabled): ?>
    <div class="my-5">&nbsp;</div>

    <div class="container">
        <div class="row">

            <?php if(settings()->aix->transcriptions_is_enabled): ?>
                <div class="col">
                    <div class="card bg-gray-100">
                        <div class="card-body py-5 py-lg-6 d-flex justify-content-center align-items-center">
                            <div class="mr-3 p-3 rounded w-fit-content bg-gray-500 text-gray-200">
                                <i class="fas fa-microphone-alt fa-fw fa-lg"></i>
                            </div>

                            <span class="h2 text-gray-800"><?= l('index.transcriptions') ?></span>
                        </div>
                    </div>
                </div>
            <?php endif ?>

            <?php if(settings()->aix->syntheses_is_enabled): ?>
                <div class="col">
                    <div class="card bg-gray-800">
                        <div class="card-body py-5 py-lg-6 d-flex justify-content-center align-items-center">
                            <div class="mr-3 p-3 rounded w-fit-content bg-gray-500 text-gray-200">
                                <i class="fas fa-voicemail fa-fw fa-lg"></i>
                            </div>

                            <span class="h2 text-gray-100"><?= l('index.syntheses') ?></span>
                        </div>
                    </div>
                </div>
            <?php endif ?>

        </div>
    </div>
<?php endif ?>


<?php if(settings()->aix->chats_is_enabled): ?>
    <div class="my-5">&nbsp;</div>

    <div class="container">
        <div class="text-center mb-4">
            <h3 class="h3"><?= l('index.chats') ?></h3>
            <p class="text-muted"><?= l('index.chats.subheader') ?></p>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <?php foreach($data->chat_messages as $chat_message): ?>
                    <div class="<?= $chat_message->role == 'user' ? '' : 'bg-gray-100' ?> p-3 rounded d-flex mb-3" data-aos="fade-up">
                        <div class="mr-3">
                            <img src="<?= $chat_message->role == 'user' ? get_gravatar('') : (settings()->aix->chats_avatar ? \Altum\Uploads::get_full_url('chats_assistants') . settings()->aix->chats_avatar : get_gravatar('')) ?>" class="ai-chat-avatar rounded" loading="lazy" />
                        </div>

                        <div>
                            <div class="font-weight-bold small <?= $chat_message->role == 'user' ? 'text-primary' : 'text-muted' ?>">
                                <?= $chat_message->role == 'user' ? 'Jhon' : 'AppaiBot' ?>
                            </div>
                            <div class="chat-content"><?= nl2br(e($chat_message->content)) ?></div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="<?= url('chats') ?>" method="get" role="form">
                    <input type="hidden" name="global_token" value="<?= \Altum\Csrf::get('global_token') ?>" />
                    <input type="hidden" name="latest" value="" />

                    <div class="input-group">
                        <input type="text" name="content" class="form-control" placeholder="<?= l('chats.content_placeholder') ?>">
                        <div class="input-group-append">
                            <button type="submit" name="submit" class="btn btn-block btn-primary"><i class="fas fa-fw fa-sm fa-paper-plane mr-1"></i> <?= l('global.submit') ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif ?>


<?php if(settings()->aix->documents_is_enabled): ?>
    <div class="my-5">&nbsp;</div>

    <div class="container">
        <div class="card bg-gray-900">
            <div class="card-body py-5 py-lg-6 text-center">
                <span class="h3 text-gray-100"><?= sprintf(l('index.stats'), nr(100, 0, true, true) . '+') ?></span>
            </div>
        </div>
    </div>
<?php endif ?>



<?php if(settings()->main->display_index_testimonials): ?>
    <div class="my-5">&nbsp;</div>

    <div class="py-7 bg-primary-100">
        <div class="container">
            <div class="text-center">
                <h2><?= l('index.testimonials.header') ?> <i class="fas fa-fw fa-xs fa-check-circle text-primary"></i></h2>
            </div>

            <div class="row mt-8">
                <?php foreach(['one', 'two', 'three'] as $key => $value): ?>
                    <div class="col-12 col-lg-4 mb-6 mb-lg-0" data-aos="fade-up" data-aos-delay="<?= $key * 100 ?>">
                        <div class="card border-0 zoom-animation">
                            <div class="card-body">
                                <img src="<?= ASSETS_FULL_URL . 'images/index/testimonial-' . $value . '.jpeg' ?>" class="img-fluid index-testimonial-avatar" alt="<?= l('index.testimonials.' . $value . '.name') . ', ' . l('index.testimonials.' . $value . '.attribute') ?>" loading="lazy" />

                                <p class="mt-5">
                                    <span class="text-gray-800 font-weight-bold text-muted h5">“</span>
                                    <span><?= l('index.testimonials.' . $value . '.text') ?></span>
                                    <span class="text-gray-800 font-weight-bold text-muted h5">”</span>
                                </p>

                                <div class="blockquote-footer mt-4">
                                    <span class="font-weight-bold"><?= l('index.testimonials.' . $value . '.name') ?></span>, <span class="text-muted"><?= l('index.testimonials.' . $value . '.attribute') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
<?php endif ?>


<?php if(settings()->main->display_index_plans): ?>
    <style>
        .pricing-card {
            border: 1px solid #1e3b89;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            background-color: #000;
        }

        .pricing-card:hover {
            transform: translateY(-10px);
        }

        .pricing-card h4 {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .pricing-card h5 {
            font-size: 1.25rem;
            color: #007bff;
        }

        .pricing-card ul {
            padding-left: 0;
            list-style: none;
        }

        .pricing-card ul li {
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .pricing-card ul li span.text-muted {
            color: #6c757d;
        }

        .pricing-card .btn {
            margin-top: 1rem;
            font-size: 1rem;
            padding: 0.75rem 1.5rem;
        }

        .pricing-container {
            background-color: #000;
            padding: 3rem 0;
        }

        .pricing-header {
            margin-bottom: 3rem;
        }

        .pricing-header h2 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .pricing-header p {
            font-size: 1.125rem;
            color: #6c757d;
        }
    </style>

    <div class="pricing-container">
        <div class="container">
            <div class="text-center pricing-header">
                <h2><?= l('index.pricing.header') ?></h2>
                <p class="text-muted"><?= l('index.pricing.subheader') ?></p>
            </div>

            <div class="row">
                <?php 
                // Define the features
                $features = [
                    'No Ads',
                    'Incredible AI model',
                    '10 projects',
                    'API access ',
                    'AWS Polly API',
                    '10 AI Documents / month',
                    '1,000 AI words / month',
                    '10 AI images / month',
                    '10 AI transcriptions / month',
                    '2 MB audio files transcriptions',
                    '10 AI chats / month',
                    '100 AI chats messages / chat',
                    '10 AI syntheses / month',
                    '1,000 AI synthesized characters / month',
                ];

                // Define the plans
                $plans = [
                    [
                        'name' => 'Basic',
                        'price' => '49.99', // Assuming the price is in dollars
                        'features' => [
                            false,
                            false,
                            false,
                            false,
                            false,
                            true, // Feature 1 available
                            true, // Feature 2 available
                            true, // Feature 3 not available
                            true, // Feature 4 not available
                            true,
                            true,
                            true,
                            true,
                            true,
                        ],
                    ],
                    [
                        'name' => 'Premium',
                        'price' => '99.99', // Assuming the price is in dollars
                        'features' => [
                            true, // Feature 1 available
                            true, // Feature 2 available
                            true, // Feature 3 available
                            true, // Feature 4 available
                            true,
                            true,
                            true,
                            true,
                            true,
                            true,
                            true,
                            true,
                            true,
                            true,
                        ],
                    ],
                ];

                // Loop through and display each plan
                foreach($plans as $plan): ?>
                    <div class="col-12 col-md-6 mb-4">
                        <div class="card pricing-card h-100">
                            <div class="card-body text-center">
                                <h4 class="card-title"><?= $plan['name'] ?></h4>
                                <h5 class="card-price">$<?= $plan['price'] ?>/month</h5>
                                <ul class="list-unstyled mt-3 mb-4">
                                    <?php foreach($plan['features'] as $index => $available): ?>
                                        <li>
                                            <?php if($available): ?>
                                                <?= $features[$index] ?>
                                            <?php else: ?>
                                                <span class="text-muted"><s><?= $features[$index] ?></s></span>
                                            <?php endif ?>
                                        </li>
                                    <?php endforeach ?>
                                </ul>
                                <a href="#" class="btn btn-primary">Choose Plan</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
<?php endif ?>






<?php if(settings()->main->display_index_faq): ?>
    <div class="my-5">&nbsp;</div>

    <div class="container">
        <div class="text-center mb-5">
            <h2><?= sprintf(l('index.faq.header'), '<span class="text-primary">', '</span>') ?></h2>
        </div>

        <div class="accordion index-faq" id="faq_accordion">
            <?php foreach(['one', 'two', 'three', 'four'] as $key): ?>
                <div class="card">
                    <div class="card-body">
                        <div class="" id="<?= 'faq_accordion_' . $key ?>">
                            <h3 class="mb-0">
                                <button class="btn btn-lg font-weight-bold btn-block d-flex justify-content-between text-gray-800 px-0 icon-zoom-animation" type="button" data-toggle="collapse" data-target="<?= '#faq_accordion_answer_' . $key ?>" aria-expanded="true" aria-controls="<?= 'faq_accordion_answer_' . $key ?>">
                                    <span><?= l('index.faq.' . $key . '.question') ?></span>

                                    <span data-icon>
                                        <i class="fas fa-fw fa-circle-chevron-down"></i>
                                    </span>
                                </button>
                            </h3>
                        </div>

                        <div id="<?= 'faq_accordion_answer_' . $key ?>" class="collapse text-muted mt-2" aria-labelledby="<?= 'faq_accordion_' . $key ?>" data-parent="#faq_accordion">
                            <?= l('index.faq.' . $key . '.answer') ?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>

    <?php ob_start() ?>
    <script>
        'use strict';

        $('#faq_accordion').on('show.bs.collapse', event => {
            let svg = event.target.parentElement.querySelector('[data-icon] svg')
            svg.style.transform = 'rotate(180deg)';
            svg.style.color = 'var(--primary)';
        })

        $('#faq_accordion').on('hide.bs.collapse', event => {
            let svg = event.target.parentElement.querySelector('[data-icon] svg')
            svg.style.color = 'var(--primary-800)';
            svg.style.removeProperty('transform');
        })
    </script>
    <?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>
<?php endif ?>


<?php if(settings()->users->register_is_enabled): ?>
    <div class="my-4">&nbsp;</div>

    <div class="container">
        <div class="card" data-aos="fade-up">
            <div class="card-body py-5 py-lg-6">
                <div class="row align-items-center justify-content-center">
                    <div class="col-12 col-lg-5">
                        <div class="text-center text-lg-left mb-4 mb-lg-0">
                            <h1 class="h2 text-gray-900"><?= l('index.cta.header') ?></h1>
                            <p class="h6 text-gray-800"><?= l('index.cta.subheader') ?></p>
                        </div>
                    </div>

                    <div class="col-12 col-lg-5 mt-4 mt-lg-0">
                        <div class="text-center text-lg-right">
                            <?php if(\Altum\Authentication::check()): ?>
                                <a href="<?= url('document-create') ?>" class="btn btn-outline-primary index-button">
                                    <?= l('documents.create') ?> <i class="fas fa-fw fa-arrow-right"></i>
                                </a>
                            <?php else: ?>
                                <a href="<?= url('register') ?>" class="btn btn-outline-primary index-button">
                                    <?= l('index.cta.register') ?> <i class="fas fa-fw fa-arrow-right"></i>
                                </a>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<?php if(count($data->blog_posts)): ?>
    <div class="my-5">&nbsp;</div>

    <div class="container">
        <div class="text-center mb-5">
            <h2><?= sprintf(l('index.blog.header'), '<span class="text-primary">', '</span>') ?></h2>
        </div>

        <div class="row">
            <?php foreach($data->blog_posts as $blog_post): ?>
            <div class="col-12 col-lg-4 p-4">
                <div class="card h-100 zoom-animation-subtle">
                    <div class="card-body">
                        <?php if($blog_post->image): ?>
                                <a href="<?= SITE_URL . ($blog_post->language ? \Altum\Language::$active_languages[$blog_post->language] . '/' : null) . 'blog/' . $blog_post->url ?>" aria-label="<?= $blog_post->title ?>">
                                    <img src="<?= \Altum\Uploads::get_full_url('blog') . $blog_post->image ?>" class="blog-post-image-small img-fluid w-100 rounded mb-4" loading="lazy" />
                                </a>
                            <?php endif ?>

                        <a href="<?= SITE_URL . ($blog_post->language ? \Altum\Language::$active_languages[$blog_post->language] . '/' : null) . 'blog/' . $blog_post->url ?>">
                            <h3 class="h5 card-title mb-2"><?= $blog_post->title ?></h3>
                        </a>

                        <p class="text-muted mb-0"><?= $blog_post->description ?></p>
                    </div>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>
<?php endif ?>


<?php ob_start() ?>
<link rel="stylesheet" href="<?= ASSETS_FULL_URL . 'css/libraries/aos.min.css' ?>">
<?php \Altum\Event::add_content(ob_get_clean(), 'head') ?>

<?php ob_start() ?>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/aos.min.js' ?>"></script>

<script>
    AOS.init({
        delay: 100,
        duration: 600
    });
</script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>

