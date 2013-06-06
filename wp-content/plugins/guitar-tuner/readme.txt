=== Plugin Name ===
Contributors: Ben Taylor
Donate link: http://www.gtdb.org/donate/
Tags: guitar tuner
Requires at least: 2.9.2
Tested up to: 3.3.1
Stable tag: 1.0.3

Embed guitar tuners on your pages using short codes.

== Description ==

Over 80 guitar tuners available in a WordPress plugin. For use with short codes on posts and pages.

Examples:

* Short code for standard guitar tuning (no sharps):  `[gtdb tuner="eadgbe"]`
* Short code for guitar tunings with a sharp:  `[gtdb tuner="cfcga-sharp-e"]`
* Short code for guitar tunings with a sharp at the end: `[gtdb tuner="cf-sharp-cf-sharp-cf-sharp"]`

= Notes =
* Replace all # signs with -sharp- except for when the sharp is at the end. Then you replace the # sign with -sharp (no hypen at the end or it will brake the code)
* There is only one tuning that uses Flats and that is EbAbDbGbBbE which would look like this as chort code; `[gtdb tuner="ebabdbgbbbe"]`

= Current Available Tuners: 85 =
* AAAGGG
* AADEBE
* ABEF#AD
* ACDEGA
* ADGBE
* AEADGC
* BAGDAD
* BBDGBE
* BDDDDD
* BEADF#B
* BEBEBE
* C#AC#G#AE
* C#F#BEG#C#
* C#G#C#FG#C#
* CA#CFA#F
* CACGCE
* CADGBE
* CEG#CEG#
* CF#CF#CF#
* CFA#D#GC
* CFCFCF
* CFCGA#E
* CFCGAE
* CFCGCD
* CGCFAD
* CGCFCD
* CGCFCE
* CGCGAE
* CGCGCE
* CGCGCG
* CGDAEB
* CGDGAD
* CGDGBC
* CGDGBD
* CGDGBE
* CGEGCC
* DACGCE
* DADABE
* DADDAD
* DADEAD
* DADEAE
* DADF#AD
* DADF#BE
* DADFAD
* DADGA#D
* DADGAD
* DADGBD
* DADGBE
* DAEAEE
* DAEFCE
* DGCFAD
* DGDF#AB
* DGDFAA#
* DGDFCD
* DGDGA#D
* DGDGAD
* DGDGBD
* DGDGCD
* EAC#EAE
* EACGBE
* EADEAE
* EADEBE
* EADEEA
* EADF#BE
* EADGAE
* EADGBE
* EADGBE_FULL_DOWN
* EADGBE_HALF_DOWN
* EADGCF
* EAEAC#E
* EBABDBGBBBE
* EBEG#BE
* EBEGBE
* EBGDAD
* EBGDAE
* ECDFAD
* F#A#C#F#A#F#
* FA#D#G#CF
* FACGCE
* FAGFAG
* FCFG#CF
* GBDGBD
* GGDXXX
* GGGAAA
* XGCEAE

== Installation ==

1. Upload the `guitar-tuner` directory to the `/wp-content/plugins/` directory.
1. Activate the plugin through the 'Plugins' menu in WordPress, You will find it under "GTDB Guitar Tuners".
1. Place [gtdb tuner="eadgbe"] in your post and pages.

== Frequently Asked Questions ==

= Can I have more than one tuner on a single page? =
I am sorry, but the GTDB Guitar Tuner does not support more than one tuner per page yet.

== Screenshots ==
1. Screenshot of the guitar tuner using shortcode '[gtdb tuner="eadgbe"]'.

== Changelog ==

= 1.0.2 =
* Added backlinks to http://www.gtdb.org and wordpress plugin page http://wordpress.org/extend/plugins/guitar-tuner/ 

= 1.0.1 =
* Minor code optimization

= 1.0 =
* First published

== Upgrade Notice ==

= N/A =

== Arbitrary section ==

None

== A brief Markdown Example ==
Short code for standard guitar tunings:`[gtdb tuner="eadgbe"]`


Short code for guitar tunings with a sharp:`[gtdb tuner="cfcga-sharp-e"]`


Short code for guitar tunings with a sharp at the end
<b>note:</b> remove hyphen from the sharp if it's at the end:`[gtdb tuner="cf-sharp-cf-sharp-cf-sharp"]`


Currently this plugin will only allow for one tuner per page. If you add short code for another then only the short code will print on your page.

