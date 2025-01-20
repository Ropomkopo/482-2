<?php
class ModelSettingFriendlyurls extends Model {
  
  public function getAvailableLangs() {
	return array_keys($this->urls);
  }
  
  public function getFriendlyUrls($lang) {
    if (strstr($lang, '-', true)) {
      $lang = strtolower(strstr($lang, '-', true));
    } else {
      $lang = strtolower($lang);
    }
    
    if(isset($this->urls[$lang]))
      return $this->urls[$lang];
    return $this->urls['en'];
  }
  
  public $urls = array(
    'en' => array(
      //'common/home'           => '',
      'account/account'       => 'account',
      'account/address'       => 'account/address',
      'account/download'      => 'account/download',
      'account/edit'          => 'account/edit',
      'account/forgotten'     => 'account/forgotten',
      'account/login'         => 'account/login',
      'account/logout'        => 'account/logout',
      'account/newsletter'    => 'account/newsletter',
      'account/order'         => 'account/order',
      'account/password'      => 'account/password',
      'account/register'      => 'account/register',
      'account/return'        => 'account/return',
      'account/return/insert' => 'account/return/insert',
      'account/reward'        => 'account/reward',
      'account/transaction'   => 'account/transaction',
      'account/voucher'       => 'account/voucher',
      'account/wishlist'      => 'account/wishlist',
      'information/contact'   => 'contact',
      'information/sitemap'   => 'sitemap',
      //'checkout/cart'         => 'cart',
      'checkout/checkout'     => 'checkout',
      'checkout/voucher'      => 'voucher',
      'product/compare'       => 'compare',
      'product/manufacturer'  => 'manufacturer',
      //'product/search'        => 'search',
      'product/special'       => 'special',
      'affiliate/account'     => 'affiliate/account',
      'affiliate/login'       => 'affiliate/login',
      'affiliate/logout'      => 'affiliate/logout',
      'affiliate/edit'        => 'affiliate/edit',
      'affiliate/forgotten'   => 'affiliate/forgotten',
      'affiliate/password'    => 'affiliate/password',
      'affiliate/register'    => 'affiliate/register',
      'affiliate/tracking'    => 'affiliate/tracking',
      'affiliate/transaction' => 'affiliate/transaction',
    ),
    
    'fr' => array(
      //'common/home'           => '',
      'account/account'       => 'compte',
      'account/address'       => 'compte/addresse',
      'account/download'      => 'compte/telechargements',
      'account/edit'          => 'compte/profil',
      'account/forgotten'     => 'compte/oubli',
      'account/login'         => 'compte/login',
      'account/logout'        => 'compte/logout',
      'account/newsletter'    => 'compte/newsletter',
      'account/order'         => 'compte/commandes',
      'account/password'      => 'compte/password',
      'account/register'      => 'compte/enregistrement',
      'account/return'        => 'compte/retours',
      'account/return/insert' => 'compte/retours/ajout',
      'account/reward'        => 'compte/reward',
      'account/transaction'   => 'compte/transaction',
      'account/voucher'       => 'compte/voucher',
      'account/wishlist'      => 'compte/wishlist',
      'information/contact'   => 'contact',
      'information/sitemap'   => 'sitemap',
      //'checkout/cart'         => 'panier',
      'checkout/checkout'     => 'commande',
      'checkout/voucher'      => 'cheque-cadeau',
      'product/compare'       => 'comparer',
      'product/manufacturer'  => 'marque',
      //'product/search'        => 'recherche',
      'product/special'       => 'special',
      'affiliate/account'     => 'affiliate/account',
      'affiliate/login'       => 'affiliate/login',
      'affiliate/logout'      => 'affiliate/logout',
      'affiliate/edit'        => 'affiliate/edit',
      'affiliate/forgotten'   => 'affiliate/forgotten',
      'affiliate/password'    => 'affiliate/password',
      'affiliate/register'    => 'affiliate/register',
      'affiliate/tracking'    => 'affiliate/tracking',
      'affiliate/transaction' => 'affiliate/transaction',
    ),

    'pt' => array(
		// 'common/home' => '',
		'account/account' => 'conta',
		'account/address' => 'conta/morada',
		'account/download' => 'conta/download',
		'account/edit' => 'conta/editar',
		'account/forgotten' => 'conta/recuperar-password',
		'account/login' => 'conta/entrar',
		'account/logout' => 'conta/sair',
		'account/newsletter' => 'conta/newsletter',
		'account/order' => 'conta/encomendas',
		'account/password' => 'conta/password',
		'account/register' => 'conta/registar',
		'account/return' => 'conta/itens-retornados',
		'account/reward' => 'conta/classificacao',
		'account/transaction' => 'conta/transacoes',
		'account/voucher' => 'conta/voucher',
		'account/wishlist' => 'conta/lista-desejos',
		'information/contact' => 'contatos',
		'information/sitemap' => 'sitemap',
		//'checkout/cart' => 'cesto',
		'checkout/checkout' => 'fechar-pedido',
		'checkout/voucher' => 'voucher',
		'product/compare' => 'comparar',
		'product/manufacturer' => 'fabricantes',
		//'product/search' => 'pesquisa',
		'product/special' => 'promocoes',
		'affiliate/account' => 'affiliate/account',
		'affiliate/login' => 'affiliate/login',
		'affiliate/logout' => 'affiliate/logout',
		'affiliate/edit' => 'affiliate/edit',
		'affiliate/forgotten' => 'affiliate/forgotten',
		'affiliate/password' => 'affiliate/password',
		'affiliate/register' => 'affiliate/register',
		'affiliate/tracking' => 'affiliate/tracking',
		'affiliate/transaction' => 'affiliate/transaction',
    ),
	
	
  );
}