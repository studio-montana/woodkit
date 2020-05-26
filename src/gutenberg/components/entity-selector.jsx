import { __ } from '@wordpress/i18n'
const { Component } = wp.element
const { Button, SelectControl } = wp.components

import WKG_Post_Selector from 'wkgcomponents/post-selector'
import WKG_Term_Selector from 'wkgcomponents/term-selector'

export default class WKG_Entity_Selector extends Component {

  constructor (props) {
    super(props)
  }

 	_onChange (value) {
 		if (this.props.onChange) {
 			this.props.onChange(value)
 		} else {
 			console.warn('WKG_Entity_Selector doit recevoir la propriété \'onChange={value => func()}\'')
 		}
 	}

  _onTypeChange (type) {
    this._onChange({type, id: this.props.value.id})
  }

  _onIdChange (id) {
    this._onChange({type: this.props.value.type, id})
  }

	render () {
    let types = this.props.types || [
      {slug: 'post', label: __('Post', 'wooden'), post_types: null},
      {slug: 'term', label: __('Term', 'wooden'), taxonomies: null}
    ]
    let types_options = []
    for (var type of types) {
      types_options.push({value: type.slug, label: type.label})
    }
    let selected_type = types.filter(type => this.props.value && this.props.value.type === type.slug)[0]
    selected_type = selected_type || types[0].slug // default is the first

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
			<div className="entity-selector">
        <div className="type">
  				<SelectControl
            label={this.props.type_selector_label}
  					options={types_options}
  					onChange={value => this._onTypeChange(value)}
  					value={selected_type.slug}
  				/>
        </div>
        <div className="item">
          { selected_type.slug === 'post' &&
            <WKG_Post_Selector
              post_types={this.props.post_types}
              label={this.props.display_entity_selector_label ? selected_type.label : null}
              value={this.props.value && this.props.value.id ? this.props.value.id : null}
              onChange={value => this._onIdChange(value)}
            />
          }
          { selected_type.slug === 'term' &&
            <WKG_Term_Selector
              taxonomies={this.props.taxonomies}
              label={this.props.display_entity_selector_label ? selected_type.label : null}
              value={this.props.value && this.props.value.id ? this.props.value.id : null}
              onChange={value => this._onIdChange(value)}
            />
          }
        </div>
			</div>
    )
  }
}

const styles = {
	selector: {
	}
}
