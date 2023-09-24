<?php

namespace App\Http\Controllers;

use App\Http\Requests\Report\ReportEditRequest;
use App\Http\Requests\Report\ReportStoreRequest;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReportController extends BaseController
{
    public function index()
    {
        $reports = $this->reportRepository->getReports();

        if (!$reports) {
            return self::httpBadRequest(self::NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'data' => $reports,
        ], Response::HTTP_OK);
    }

    public function show($id)
    {
        $report = $this->reportRepository->getReportById($id);

        if (!$report) {
            return self::httpBadRequest(self::NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'data' => $report,
        ], Response::HTTP_OK);
    }

    public function store(ReportStoreRequest $request)
    {
        $report = Report::createReport($request, $this->user->id);
        if ($report) {
            return response()->json([
                'status' => 'success',
                'data' => $report,
            ], Response::HTTP_CREATED);
        }

        return self::httpBadRequest(self::SOMETHING_WENT_WRONG);
    }

    public function update(ReportEditRequest $request, $id)
    {
        $report = $this->reportRepository->getReportById($id);

        if (!$report) {
            return self::httpBadRequest(self::NOT_FOUND, Response::HTTP_NOT_FOUND);
        }

        $report = Report::updateReport($request, $report);

        if ($report) {
            return response()->json([
                'status' => 'success',
                'data' => $report->refresh(),
            ], Response::HTTP_OK);
        } else {
            return self::httpBadRequest(self::SOMETHING_WENT_WRONG);
        }
    }

    public function destroy($id)
    {
        $report = $this->reportRepository->getReportById($id);

        if (!$report) {
            return self::httpBadRequest(self::NOT_FOUND, Response::HTTP_NOT_FOUND);
        }
        $res = $report->delete();

        if ($res) {
            return response()->json([
                'status' => 'success',
            ], Response::HTTP_OK);
        } else {
            return self::httpBadRequest(self::SOMETHING_WENT_WRONG);
        }
    }

}
