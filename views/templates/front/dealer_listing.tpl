{extends file='page.tpl'}

{block name='head_seo_title'}{$pagetitle}{/block}

{block name='page_header_container'}
    {block name='page_title'}
        <header class="page-header">
            <h1>{$pagetitle}</h1>
        </header>
    {/block}
{/block}
{block name='page_content_container'}
    <section id="content" class="page-content">
        {block name='page_content_top'}{/block}
        {block name='page_content'}
            {foreach $dealers as $dealer}
                <div class="row dealers">
                    <div class="dealers-info">
                        <div class="dealer-name">
                            <h2>{$dealer.name}</h2>
                        </div>
                        <div class="dealer-brands">
                            {foreach $dealer.brand as $dbrand}
                                <div class="dbrand dbrand-{$brands[$dbrand]|lower}">
                                    <img src="{$urls.img_ps_url}dealers/brands/{$dbrand}.jpg" alt="{$brands[$dbrand]}">
                                </div>
                            {/foreach}
                        </div>
                        {if !empty($dealer.tel) || !empty($dealer.fax) || !empty($dealer.email)}
                            <div class="dealer-contact">
                                {if !empty($dealer.tel)}<div class="info-tel">Tel: {$dealer.tel}</div>{/if}
                                {if !empty($dealer.fax)}<div class="info-fax">Fax: {$dealer.fax}</div>{/if}
                                {if !empty($dealer.email)}<div class="info-email">Email: {$dealer.email}</div>{/if}
                            </div>
                        {/if}
                        {if !empty($dealer.facebook) || !empty($dealer.twitter) || !empty($dealer.instagram) || !empty($dealer.web)}
                            <div class="dealer-social">
                                {if !empty($dealer.facebook)}
                                    <div class="info-fb">
                                        <a href="{$dealer.facebook}" rel="external" target="_blank">
                                            <i class="fa fa-facebook-square" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                {/if}

                                {if !empty($dealer.twitter)}
                                    <div class="info-twi">
                                    <a href="{$dealer.twitter}" rel="external" target="_blank">
                                        <i class="fa fa-twitter" aria-hidden="true"></i>
                                    </a>
                                    </div>
                                {/if}
                                {if !empty($dealer.instagram)}
                                    <div class="info-ig">
                                        <a href="{$dealer.instagram}" rel="external" target="_blank">
                                            <i class="fa fa-instagram" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                {/if}
                                {if !empty($dealer.web)}
                                    <div class="info-web">
                                        <a href="{$dealer.web}" rel="external" target="_blank">
                                            <i class="material-icons">language</i>
                                        </a>
                                    </div>
                                {/if}
                            </div>
                        {/if}
                    </div>
                    <div class="dealers-address">
                        <div class="info-address">Address: {$dealer.address}</div>
                        <div class="info-map">
                            <iframe src="{$dealer.map_link}" width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                        </div>
                    </div>
                </div>
            {/foreach}
        {/block}
    </section>
{/block}
