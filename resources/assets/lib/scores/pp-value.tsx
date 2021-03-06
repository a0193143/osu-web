// Copyright (c) ppy Pty Ltd <contact@ppy.sh>. Licensed under the GNU Affero General Public License v3.0.
// See the LICENCE file in the repository root for full licence text.

import ScoreJson from 'interfaces/score-json';
import * as React from 'react';

interface Props {
  score: ScoreJson;
}

export default function PpValue(props: Props) {
  if (props.score.pp == null || props.score.pp === 0) {
    return (
      <span
        className='fas fa-exclamation-triangle'
        title={osu.trans('scores.status.processing')}
      />
    );
  }

  return (
    <span title={osu.formatNumber(props.score.pp)}>
      {osu.formatNumber(Math.round(props.score.pp))}
    </span>
  );
}
