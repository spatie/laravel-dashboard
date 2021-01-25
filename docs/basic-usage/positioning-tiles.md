---
title: Positioning tiles
weight: 3
---

Most tiles accept a position property. You can pass a single position like `a1`. You should imagine the dashboard as an excel-like layout. The columns are represented by letters, the rows by number. The first letter, `a`, represents the first column. The `1` represents the first row. You an also pass ranges. Here are a few examples.

- `a1`: display the tile in the top left corner
- `b2`: display a tile in the second row of the second column
- `a1:a3`: display a tile over the three first rows of the first column
- `b1:c2`: display the tile as a square starting at the first row of the second column to the second row of the third column

The dashboard is being rendered using css grid. Behind the scenes, these coordinates will be converted to grid classes. The grid will grow automatically. If a `c` is the "highest" letter used on the dashboard, it will have 3 columns, if a `e` is used on any tile, the dashboard will have 5 columns. The same applies with the rows.
