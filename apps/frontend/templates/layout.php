<!DOCTYPE html PUBLIC
	"-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
    </head>
    <body>
        <div id="header-wrapper">
            <div id="header">
                <h1>Project-Y</h1>
            </div>
        </div>
        <div id="main-wrapper">
            <div id="main">
                <div id="sidebar">
                    <?php if($sf_user->isAuthenticated()): ?>
                        <?php include_component('user', 'user') ?>
                    <?php endif; ?>
                </div>
                <div id="content">
                    <?php echo $sf_content ?>
                </div>
            </div>
        </div>
        <div id="footer-wrapper">
            <div id="footer">
                <p>Copyright &copy; <?php echo date("Y") ?> <?php echo link_to('Hoydaa Inc.', 'http://www.hoydaa.org', array('target' => '_blank', 'title' => 'deliver few, deliver complete')) ?> All rights reserved.</p>
            </div>
        </div>
    </body>
</html>
