import { __ } from '@wordpress/i18n'
const { Component } = wp.element
const { compose } = wp.compose
const { withSelect, withDispatch } = wp.data

class WKG_Tips_Tricks extends Component {

  constructor (props) {
    super(props)
    this.state = {}
  }

 	componentDidMount () {}

	render () {
    console.log('this.props.posts : ', this.props.posts);
    console.log('this.props.terms : ', this.props.terms);
  	return (
			<div>
				This is just a tips and trick component !
			</div>
    )
  }
}

const applyWithSelect = withSelect((select, props) => {
		const { getEntityRecords, getPostTypes, getTaxonomies } = select('core')

    /********************************************************/
    /* GET POSTS FROM WP STORE                              */
    /********************************************************/
    /** parse post types */
    let types = getPostTypes()
    if (types) {
      if (props.post_types) {
        types = types.filter(type => props.post_types.includes(type.slug))
      } // exclude media (please use WKG_Media_Selector) and gutenberg blocks
      types = types.filter(type => type.slug !== 'attachment' && type.slug !== 'wp_block')
    }
    /** retrieve posts */
    let posts = []
    let query = {...{
      per_page : -1, // set -1 to display ALL
      // exclude : 50, // or pass multiple values in an array, e.g. [ 1, 9098 ]
      // parent_exclude : 43, // or [ 43, 44, 98 ]
      // orderby : 'date',
      // order : 'asc',
      // status : 'publish', // or [ 'publish', 'draft', 'future' ]
      // categories : [ 5, 10, 15 ], // category ID or IDs
      // tags : 4, // tag ID, you can pass multiple too [ 4, 7 ]
      // search : 'search query',
    }, ...props.query}
    if (types) {
      for (var type of types) {
        posts[type.slug] = getEntityRecords('postType', type.slug, query)
      }
    }

    /********************************************************/
    /* GET TERMS FROM WP STORE                              */
    /********************************************************/
    /** parse taxonomies */
    let taxonomies = getTaxonomies()
    if (taxonomies) {
      if (props.tax) {
        taxonomies = taxonomies.filter(tax => props.tax.includes(tax.slug))
      } // exclude media (please use WKG_Media_Selector) and gutenberg blocks
      taxonomies = taxonomies.filter(tax => tax.slug !== 'attachment' && tax.slug !== 'wp_block')
    }
    /** retrieve terms */
    let terms = []
    let query = {...{
      per_page: -1, //	Maximum number of items to be returned in result set.
      // hide_empty: true, //	Whether to hide terms not assigned to any posts. Note: to set false, do not passes this parameter
      // page: 1, //	Current page of the collection.
      // search: 10, //	Limit results to those matching a string.
      // exclude: [], //	Ensure result set excludes specific IDs.
      // include: [], //	Limit result set to specific IDs.
      // offset: 1, //	Offset the result set by a specific number of items.
      // order: 'asc', //	Order sort attribute ascending or descending. One of: asc, desc
      // orderby: 'name', //	Sort collection by term attribute. One of: id, include, name, slug, include_slugs, term_group, description, count
      // post: 'post', //	Limit result set to terms assigned to a specific post
      // slug: '', // Limit result set to terms with one or more specific slugs.
    }, ...props.query}
    if (taxonomies) {
      for (var tax of taxonomies) {
        terms[tax.slug] = getEntityRecords('taxonomy', tax.slug, query)
      }
    }

    return { posts, terms }
})

export default compose(
    applyWithSelect,
)(WKG_Tips_Tricks)
