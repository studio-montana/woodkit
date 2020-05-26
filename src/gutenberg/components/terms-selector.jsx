import { __ } from '@wordpress/i18n'
const { Component } = wp.element
const { Button, CheckboxControl } = wp.components
const { compose } = wp.compose
const { withSelect, withDispatch } = wp.data

/**
 * IMPORTANT : this component is not tested !
 */

class WKG_Terms_Selector extends Component {

	constructor (props) {
    super(props)
		this.state = {
			selected: []
		}
  }

	componentDidMount () {
		this.setState({
			selected: this.props.value
		})
	}

	async _onChange (value, checked) {
		if (this.props.onChange) {
      let selected = null
      if (checked) {
        selected = this.state.selected
        selected.push(parseInt(value))
      } else {
        selected = this.state.selected.filter(id => id !== parseInt(value))
      }
			await this.setState({selected})
			let selected_objects = this.props.terms.filter(p => this.state.selected.indexOf(p.id) !== -1)
			this.props.onChange(this.state.selected, selected_objects)
		} else {
			console.warn('WKG_Category_Selector doit recevoir la propriété \'onChange={value => func()}\'')
		}
	}

	render () {
		let checkboxes = []
		if (this.props.terms) {
			this.props.terms.forEach((term) => {
        let checked = this.state.selected.indexOf(term.id) !== -1
				checkboxes.push(
          <CheckboxControl value={term.id} label={term.name} checked={checked} onChange={checked => this._onChange(term.id, checked)} />
        )
			})
		} else {
			checkboxes.push(<div>Loading...</div>)
		}
    let selectedId = this.state.selected ? this.state.selected.id : 0
  	return (
			<div className="wkg-terms-selector">
				{checkboxes}
			</div>
    )
  }
}

const applyWithSelect = withSelect(select => {
		const { getEntityRecords, getTaxonomies } = select('core')

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

    return { terms, taxonomies }
})

export default compose(
    applyWithSelect,
)(WKG_Terms_Selector)
