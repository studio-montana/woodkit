const { Component } = wp.element
const { __ } = wp.i18n
const { Button, SelectControl } = wp.components
const { compose } = wp.compose
const { withSelect, withDispatch } = wp.data

class WKG_Term_Selector extends Component {

  constructor (props) {
    super(props)
    this.state = {
      selected: null
    }
  }

 	componentDidMount () {
 		this.setState({
 			selected: this.props.value && this.props.value.id ? this.props.value.id : this.props.value
 		})
 	}

 	_onChange (value) {
 		if (this.props.onChange) {
 			this.setState({
 				selected: value
 			})
 			let terms = this.props.terms.filter(p => p.id === parseInt(value))
 			this.props.onChange(parseInt(value), terms.length > 0 ? terms[0] : null)
 		} else {
 			console.warn('WKG_Term_Selector doit recevoir la propriété \'onChange={value, term => func()}\'')
 		}
 	}

	render () {
    let options = []
    if (this.props.taxonomies) {
      for (var tax of this.props.taxonomies) {
        if (this.props.terms && this.props.terms[tax.slug]) {
          options.push({value: 0, label: tax.name, disabled: true})
          this.props.terms[tax.slug].forEach((term) => {
    				options.push({value: term.id, label: term.name, disabled: false})
    			})
        } else {
          options.push({value: 0, label: tax.name+' '+__('loading...', 'wooden'), disabled: true})
        }
      }
    } else {
      options.push({value: 0, label: this.props.label_loading ? this.props.label_loading : 'Chargement...', disabled: true})
    }
  	return (
			<div className="wkg-term-selector">
				<SelectControl
          label={this.props.label}
					options={options}
					onChange={value => this._onChange(value)}
					value={this.state.selected}
				/>
			</div>
    )
  }
}

const applyWithSelect = withSelect((select, props) => {
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
)(WKG_Term_Selector)
