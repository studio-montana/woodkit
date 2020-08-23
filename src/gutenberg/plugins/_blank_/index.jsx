import { __ } from '@wordpress/i18n'
const { registerPlugin } = wp.plugins
const { Component, Fragment } = wp.element
const { withSelect, withDispatch } = wp.data
const { compose } = wp.compose
const { PluginDocumentSettingPanel } = wp.editPost
const { TextControl } = wp.components

registerPlugin('wkg-plugin-_blank_', {
  icon: 'admin-customizer',
  render: (props) => {
    return (
      <PluginDocumentSettingPanel name="wkg-plugin-_blank_" title={__('Custom panel', 'woodkit')} className="wkg-document-setting-panel wkg-plugin-_blank_">
          <PluginComponent />
      </PluginDocumentSettingPanel>
    )
  }
})

class PluginComponent_Base extends Component {
	constructor(props) {
		super(props)
	}
	render () {
		return (
			<Fragment>
				<div className="wkg-content">
          <div className="wkg-panel-row">
            <div className="wkg-description">
            	<TextControl label={__('Custom meta', 'woodkit')} value={this.props._custom_meta_name} onChange={(value) => this.props.on_meta_change({'_custom_meta_name': value})} />
            </div>
          </div>
				</div>
			</Fragment>
		)
	}
}

const applyWithSelect = withSelect(select => {
  let core_editor_store = select('core/editor')
  return {
	  _custom_meta_name: core_editor_store.getEditedPostAttribute('meta')['_custom_meta_name'],
  }
})

const applyWithDispatch = withDispatch(dispatch => {
  let core_editor_store = dispatch('core/editor')
  return {
    on_meta_change: (meta) => {
      core_editor_store.editPost({meta})
    },
  }
})

const PluginComponent = compose(
    applyWithSelect,
    applyWithDispatch,
)(PluginComponent_Base)

const styles = {}
