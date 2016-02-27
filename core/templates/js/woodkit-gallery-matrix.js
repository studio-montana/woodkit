/**
 * @package WordPress
 * @version 1.0
 * @author Sébastien Chandonay www.seb-c.com / Cyril Tissot www.cyriltissot.com This file, like this theme, like WordPress, is licensed under the GPL.
 */

/**
 * matrix = { window_size : { columns : new isotope columns , wrapper-data-columns : { item-data-columns : "new item width in percent" } } } IMPORTANT : respect window_size's order (always ascendent -
 * never : 800 before 600 for example)
 */
function woodkit_resize_gallery_matrix() {
	return {
		480 : { // window size
			columns : 1, // new isotope columns
			6 : { // initial isotope columns
				6 : "100%", // initial item columns : new item width in percent
				5 : "100%",
				4 : "100%",
				3 : "100%",
				2 : "100%",
				1 : "100%"
			},
			5 : {
				5 : "100%",
				4 : "100%",
				3 : "100%",
				2 : "100%",
				1 : "100%"
			},
			4 : {
				4 : "100%",
				3 : "100%",
				2 : "100%",
				1 : "100%"
			},
			3 : {
				3 : "100%",
				2 : "100%",
				1 : "100%"
			},
			2 : {
				2 : "100%",
				1 : "100%"
			},
			1 : {
				1 : "100%"
			}
		},
		640 : {
			columns : 2,
			6 : {
				6 : "100%",
				5 : "100%",
				4 : "50%",
				3 : "50%",
				2 : "50%",
				1 : "50%"
			},
			5 : {
				5 : "100%",
				4 : "100%",
				3 : "100%",
				2 : "50%",
				1 : "50%"
			},
			4 : {
				4 : "100%",
				3 : "100%",
				2 : "50%",
				1 : "50%"
			},
			3 : {
				3 : "100%",
				2 : "50%",
				1 : "50%"
			},
			2 : {
				2 : "100%",
				1 : "50%"
			},
			1 : {
				1 : "100%"
			}
		},
		800 : {
			columns : 4,
			6 : {
				6 : "100%",
				5 : "100%",
				4 : "50%",
				3 : "50%",
				2 : "25%",
				1 : "25%"
			},
			5 : {
				5 : "100%",
				4 : "100%",
				3 : "100%",
				2 : "50%",
				1 : "50%"
			},
			4 : {
				4 : "100%",
				3 : "100%",
				2 : "50%",
				1 : "50%"
			},
			3 : {
				3 : "100%",
				2 : "100%",
				1 : "50%"
			},
			2 : {
				2 : "100%",
				1 : "50%"
			},
			1 : {
				1 : "100%"
			}
		}
	};
}