{extends file='page.tpl'}

{block name='head_seo_title'}{$pagetitle}{/block}

{block name='page_header_container'}
    {block name='page_title'}
        <header class="page-header dealers-header">
            <h1>{$pagetitle}</h1>
        </header>
    {/block}
{/block}
{block name='page_content_container'}
    <section id="content" class="page-content">
        {block name='page_content_top'}{/block}
        {block name='page_content'}
            <div class="dealers dealers-grid">
            {foreach $dealers as $dealer}
                <div class="dealer-card">
                    <div class="dealer-info">
                        <div class="dealer-name">
                            <h2>{$dealer.name}</h2>
                        </div>
                        <div class="dealer-brands">
                            {foreach $dealer.brand as $dbrand}
                                <div class="dbrand dbrand-{$brands[$dbrand]|lower}">
                                    <img class="img-fluid" src="{$urls.img_ps_url}dealers/brands/{$dbrand}.jpg" alt="{$brands[$dbrand]}">
                                </div>
                            {/foreach}
                        </div>
                        {if !empty($dealer.tel) || !empty($dealer.fax) || !empty($dealer.email)}
                            <div class="dealer-contact">
                                {if !empty($dealer.tel)}<div class="dinfo dinfo-tel"><strong>Tel: </strong>{$dealer.tel}</div>{/if}
                                {if !empty($dealer.fax)}<div class="dinfo dinfo-fax"><strong>Fax: </strong>{$dealer.fax}</div>{/if}
                                {if !empty($dealer.email)}<div class="dinfo dinfo-email"><strong>Email: </strong>{$dealer.email}</div>{/if}
                                {if !empty($dealer.address)}<div class="dinfo dinfo-address"><strong>Address: </strong>{$dealer.address}</div>{/if}
                            </div>
                        {/if}
                        {if !empty($dealer.facebook) || !empty($dealer.twitter) || !empty($dealer.instagram) || !empty($dealer.web)}
                            <div class="dealer-social">
                                {if !empty($dealer.facebook)}
                                    <div class="dinfo dinfo-fb">
                                        <a href="{$dealer.facebook}" rel="external" target="_blank">
                                            <i class="fa fa-facebook-square" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                {/if}

                                {if !empty($dealer.twitter)}
                                    <div class="dinfo dinfo-twi">
                                    <a href="{$dealer.twitter}" rel="external" target="_blank">
                                        <i class="fa fa-twitter" aria-hidden="true"></i>
                                    </a>
                                    </div>
                                {/if}
                                {if !empty($dealer.instagram)}
                                    <div class="dinfo dinfo-ig">
                                        <a href="{$dealer.instagram}" rel="external" target="_blank">
                                            <i class="fa fa-instagram" aria-hidden="true"></i>
                                        </a>
                                    </div>
                                {/if}
                                {if !empty($dealer.web)}
                                    <div class="dinfo dinfo-web">
                                        <a href="{$dealer.web}" rel="external" target="_blank">
                                            <i class="material-icons">language</i>
                                        </a>
                                    </div>
                                {/if}
                            </div>
                        {/if}
                    </div>
                </div>
            {/foreach}
            </div>
        {/block}
    </section>
{/block}
