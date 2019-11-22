<?php 
	ini_set('display_errors',1); //controlar errores, para que los visualicemos
	error_reporting('E_ALL'); //para que muestre también los errores fatales
	//Ambas directivas superiores se usan solo en período de desarrollo/depuración

	require_once('header.php');
    
		if(Func::checkLogin($con)){
			require_once('nav.php');
		} else {
            require_once('navnot.php');
		}
?>

	<div>
		<h1 class="text-center m-t-60 m-b-30">Opposites attract!</h1>
		<div class="d-flex flex-col flex-m">
			<div class="anchoStandar d-flex flex-row flex-wrap flex-c">
				<div class="indextext m-t-10 m-l-30 m-r-30 ancho450">
					<p class="m-t-20">Did you ever think that it was a cruel joke of nature that many of us find ourselves attracted to people very much unlike us? I mean, wouldn’t it be an awful lot simpler and a lot less messy if we tended to be drawn to those whose personalities are more like our own rather than those who seem like they are polar opposites of us? Especially given the inclination that seems to be present in most humans to see the way that we are as the “correct” way and to try to influence the other person to become more like we are, rather than vice versa. It sure can make for some “interesting’ dialogues. </p>
					<p class="m-t-20">But consider the possibility that those differences that can seem so problematic may actually be the very things that add spice and passion to your relationship, particularly its sexual aspects. We are drawn to others out of needs and desires that are unfulfilled in our lives, such as a desire to experience greater connection, security, love, support, and comfort.</p>
					<p class="m-t-20">On the other hand, some of those unfulfilled longings have to do with their polar opposites, such as adventure, freedom, risk, challenge, and intensity. While these needs and desires may appear to be mutually exclusive, they not only can co-exist with each other, but in the process, generate a “tension of the opposites” that produces the passion that sustains, deepens and enlivens relationships.</p>
				</div>
				<div class="indextext m-t-10 m-l-30 m-r-30 ancho450">
					<p class="m-t-20">In an age in which external cultural norms no longer sustain and enforce the continuation of long-term partnerships, the generating internal motivation, that which comes from within the relationship itself, is essential to its long-term growth and viability. The incentive to support that motivation comes from the ability of both partners to continue to co-create compelling experiences on an ongoing basis. While security, safety, closeness, and comfort are certainly qualities that characterize all fulfilling relationships, without a balance of excitement, passion, adventure, risk, and yes, even a certain degree of separateness, security becomes boredom, dependability becomes indifference, intimacy becomes claustrophobia, and comfort becomes stagnation. The French view this paradox not as a problem, but as something to celebrate. Rather than say “Oh merde” (look it up if you aren’t sure what this means) when this apparent contradiction shows up in a relationship, they say, “Viva la difference!”</p>
					<p class="m-t-20">It’s “la difference” that makes relationships edgy, dynamic, and exciting. As most of us know, differences can and do show up in a lot of ways. Opposites, or perhaps more accurately, “complements” do attract. And while this can create some interesting challenges for most couples, these differences are actually the source of what is considered by many to be the source of the most important aspect of any successful relationship: chemistry.</p>
				</div>
			</div>
			<div class="anchoStandar d-flex flex-row flex-wrap flex-c m-t-40">
				<img class="m-t-40 m-b-40 imagen" src="./images/couple.jpg"/>
			</div>
		</div>
	</div>
		
<?php
	require('footer.php');
?>