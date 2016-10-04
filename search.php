<?php
/*
Template Name: Search Results
*/
?>
<?php
require_once TEMPLATEPATH . "/assets/functions/GoogleSearch.php";
get_header(); 
$theme_option = flagship_sub_get_global_options(); 
$collection_name = $theme_option['flagship_sub_search_collection'];
?>

<div class="row sidebar_bg radius10">
<?php locate_template('parts-nav-sidebar.php', true, false); ?>
	<div class="nine columns wrapper radius-right offset-topgutter">
		<h2>Search Results</h2>


<?php 
try {
    $search = new KSAS_GoogleSearch();
    $resultsPageNum = 1;
    if (array_key_exists('resultsPageNum', $_REQUEST)) {
        $resultsPageNum = $_REQUEST['resultsPageNum'];
    }
    $resultsPerPage = 10;
    $baseQueryURL = 'http://search.johnshopkins.edu/search?&client=ksas_frontend';
    $results = $search->query($_REQUEST['q'], $_REQUEST['site'], $baseQueryURL, $resultsPageNum, $resultsPerPage);
    $hits = $results->getNumHits();
    $displayQuery = $results->getDisplayQuery();
    $docTitle = 'Search Results';
    $sponsored_result = $results->getSponsoredResult();
    ?>

    <?php
    if ($hits > 0) {
        ?>
       <form class="search-form" action="<?php echo site_url('/search'); ?>" method="get">
            <fieldset> 
                <label>
                    Search:
                    <input type="text" class="input-text" name="q" value="<?php echo $displayQuery ?>" />
                </label>
                <div class="row">
                    <div class="small-12 columns">
                        <input type="radio" name="site" id="thisSite" value="<?php echo $collection_name; ?>">
                            <label for="thisSite">This & Related Websites</label>
                        <input type="radio" name="site" id="krieger" value="krieger_collection">
                            <label for="krieger">Krieger Network</label>
                        <input type="radio" name="site" id="allJHU" value="jhuedu">
                            <label for="allJHU">All of JHU</label>
                    </div>   
                </div>                    
                <input type="submit" class="button blue_bg" id="search_again" value="Search Again" />
                    <label for="search_again" class="screen-reader-text">
                    Search Again
                    </label>
            </fieldset>
       </form>        
       <h6>Results <span class="black"><?php echo $results->getFirstResultNum() ?> - <?php echo $results->getLastResultNum() ?></span> of about <span class="black"><?php echo $hits ?></span></h6>
           
        <?php if (empty($sponsored_result) == false) { ?>
	        <div class="panel callout radius10" id="sponsored">
	        	<h6 class="black">Sponsored Result</h6>
	        	<a href="<?php echo $sponsored_result['sponsored_url']; ?>"><h3><?php echo $sponsored_result['sponsored_title']; ?><small class="italic">-- <?php echo $sponsored_result['sponsored_url']; ?></small></h3></a>
	        </div>
         <?php } ?>   
            <div id="search-results">
                <ul>
           
        <?php
        while ($result = $results->getNextResult()) {
            // note what results are PDFs
            $pdfNote = '';
            if (preg_match('{application/pdf}', $result['mimeType'])) {
                $pdfNote = '<span class="black">[PDF]</span> ';
            }
            ?>
                    <li>
                        <h5><?php echo $pdfNote ?><a href="<?php echo $result['path'] ?>"><?php echo $result['title'] ?></a></h5>
            <?php
            if (array_key_exists('description', $result) && $result['description']) {
                ?>
                        <p><?php echo $result['description'] ?></p>
                <?php
            }
            ?>
                        <div class="url"><?php echo $result['path'] ?> - <?php echo $result['sizeHumanReadable'] ?></div>
                    </li>
                    <hr>
            <?php
        }
        ?>
                </ul>
            </div>
             
            <div class="section">
        <?php
            $notices = $results->getNotices();
            foreach ($notices as $notice) {
                ?>
                <p class="notice"><?php echo $notice ?></p>
                <?php
            }
        ?>
                <div class="pagination">
                     
        <?php
        foreach ($results->getResultsetLinks() as $resultsetLink) {
            print "$resultsetLink ";
        }
        ?>
                    <?php echo $results->getNextLink() ?> 
                </div>
                 
            </div>
        <?php
    } else {
        // no hits
        ?>
            
             
        <?php
            $notices = $results->getNotices();
            foreach ($notices as $notice) {
                ?>
            <p class="notice"><?php echo $notice ?></p>
                <?php
            }
        ?>
             
            <p style="font-weight: bold;">There are no pages matching your search.</p>
       <form class="search-form" action="<?php echo site_url('/search'); ?>" method="get">
                    <fieldset>
                        <input type="text" class="input-text" name="q" value="<?php echo $displayQuery ?>" />
                        <label class="inline bold">Search:</label>
                        <input type="radio" name="site" value="<?php echo $collection_name; ?>" checked>This site only
                        <input type="radio" name="site" value="krieger_collection">All Krieger websites
                        <input type="submit" class="button blue_bg" value="Search Again" />
                    </fieldset>
       </form>        

        <?php
    }
} catch (KSAS_GoogleSearchException $e) {
    $docTitle = "Search Temporarily Unavailable";
    ?>
    <div class="section">
        <p>We're sorry, the search engine is temporarily unavailable. Please try your search again later.</p>
    </div>
    <?php
} ?>
		</section>
	</div>
</div>

<?php get_footer(); ?>  