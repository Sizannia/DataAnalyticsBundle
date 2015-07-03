## Configuration

### In Google Analytics

Go to this [page](https://github.com/widop/WidopGoogleAnalyticsBundle) and follow the documentation

### In your Application


This bundle used by default the api of Google Analytic.
There are several types(chaps) of block:
* The world map, to localize the origin of your various users.
    * The name of the service is ``sizannia_data_analytics.block.map``
    * For example:
    ```
          dashboard:
            blocks:
              - { position: top, class:"col-md-7", type:  sizannia_data_analytics.block.map, settings: { title: "Word Map", metrics: ["ga:sessions"], interval: 1, dimensions: ["ga:countryIsoCode"], mode: admin }}
    ```
* A block to show the data in the form of a picture(board)
    * The name of the service is ``sizannia_data_analytics.block.table``
    * For example:
    ```
          dashboard:
            blocks:
              - { position: top, class:"col-md-5", type:  sizannia_data_analytics.block.pie, settings: { title: "Browser Version", dimensions: ["ga:browser", "ga:browserVersion"], interval: 1, metrics: ["ga:sessions"], mode: admin }}
    ```
* A block to show the data in the form of a "donut" in two dimensions.
    * The name of the service is ``sizannia_data_analytics.block.pie``
    * For example:
    ```
          dashboard:
            blocks:
              - { position: center, type:  sizannia_data_analytics.block.table, settings: { title: "Provenance", dimensions: ["ga:channelGrouping"], interval: 1, metrics: ["ga:sessions"], mode: admin }}
    ```
